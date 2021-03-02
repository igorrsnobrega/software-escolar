<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Aluno;
use App\Models\Curso;
use App\Models\AlunoCurso;
use App\Models\Contrato;
use App\Models\CursoModulo;
use App\Models\Modulo;
use App\Models\Nota;
use App\Models\Parametro;
use App\Models\ParametroValor;
use App\Models\Parcela;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Codedge\Fpdf\Fpdf\Fpdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

define('FPDF_FONTPATH','../public/fonts/');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

class PDF extends FPDF{
 
    //formata rodapé 
    function Footer()
    {
        $this->SetY(10);
        $this->AddFont('arial','','arial.php');
        $this->SetFont('arial','I',8);
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
    }
 }

class AlunoCursoController extends Controller
{
    use HasFactory;

    public function __construct()
    {
      $this->middleware('auth');
    }

    public function geraQrCode($url){
        
        $qr_code = md5($url.strtotime("now")) .'.png';
        QrCode::format('png')->merge('../public/img/logo.png')->generate($url, '../public/img/qr_code/'.$qr_code);
        return $qr_code;
    }

    public function alunosCursos(){    
        
        $alunos = Aluno::all();
        $cursos = Curso::all();

        return view('vinculos/alunos-cursos', compact('alunos', 'cursos'));
    }

    public function gerarProtocolo(){
        return strtoupper(substr(md5(date("YmdHis")), 1, 10));
    }


    public function store(Request $request){
        $alunoCurso = new AlunoCurso();

        $alunoCurso->aluno_id        = $request->aluno_id;
        $alunoCurso->curso_id        = $request->curso_id;
        $alunoCurso->aluno_protocolo = $this->gerarProtocolo();
        $alunoCurso->curso_matricula = $request->data_matricula;
        $alunoCurso->curso_inicio    = $request->data_inicio_curso;
        $alunoCurso->aluno_hor       = $request->aluno_hor;

        if($alunoCurso->save()){
            return redirect('/vinculos/alunos-cursos')->with('success', 'Sucesso ao vincular');
        }else{
            return redirect('/vinculos/alunos-cursos')->with('error', 'Erro ao vincular, verifique e tente novamente');
        }
    }

    public function alunosCursosVinculados($aluno_id){
        $alunoCursoVinculados = DB::table('alunos_cursos')
                                ->select('controle_id'
                                       , 'alunos.aluno_id'
                                       , 'cursos.curso_id'
                                       , 'cursos.curso_nome_curso'
                                       , 'alunos_cursos.curso_fim'
                                       , 'alunos_cursos.curso_inicio'
                                       , 'alunos_cursos.curso_matricula'
                                       , 'alunos_cursos.aluno_hor'
                                       , 'alunos_cursos.aluno_qrcode'
                                       , 'alunos_cursos.curso_data_certificacao'
                                       , 'alunos_cursos.aluno_contrato')
                                ->join('alunos', 'alunos.aluno_id', '=', 'alunos_cursos.aluno_id')
                                ->join('cursos', 'cursos.curso_id', '=', 'alunos_cursos.curso_id')
                                ->where('alunos.aluno_id', $aluno_id)->get();

        return Response::json($alunoCursoVinculados);
    }

    public function gerarCertificado($controle_id){

        $gerarCertificado = DB::table('alunos_cursos')
                                    ->select('*')
                                    ->join('alunos', 'alunos.aluno_id', '=', 'alunos_cursos.aluno_id')
                                    ->join('cursos', 'cursos.curso_id', '=', 'alunos_cursos.curso_id')
                                    ->where('alunos_cursos.controle_id', $controle_id)
                                    ->first();

        $modulos = DB::table('cursos_modulos')
                                    ->select('*')
                                    ->join('modulos', 'modulos.modulo_id', '=', 'cursos_modulos.modulo_id')
                                    ->where('cursos_modulos.curso_id', $gerarCertificado->curso_id)
                                    ->get();

        
        return view('gerar.certificado', compact('gerarCertificado', 'modulos'));
    }

    public function geraCodigo(){
        return rand(10000,99999);
    }

    public function emitirCertificado(Request $request){

        $notas = new Nota();

        for($x = 0; $x < count($request->modulo_id); $x++){

            $notas::insert(['nota_aluno'                  => $request->aluno_id
                            , 'nota_curso'                => $request->curso_id
                            , 'nota_modulo'               => $request->modulo_id[$x]
                            , 'nota_data_certificacao'    => $request->nota_data_certificacao
                            , 'nota_observacao'           => $request->nota_observacao
                            , 'nota_data_termino'         => $request->nota_data_termino
                            , 'nota_certificacao'         => str_replace(',','.', $request->modulo_notas[$x])
                            , 'nota_frequencia'           => $request->nota_frequencia
                            , 'alunos_cursos_controle_id' => $request->alunos_cursos_controle_id
                            ]);
        }

        $aluno_protocolo = AlunoCurso::where('controle_id', $request->alunos_cursos_controle_id)->first();

        $url = "http://startlive.com.br/consulta-certificado.php?numero=".$aluno_protocolo->aluno_protocolo;

        AlunoCurso::where([['controle_id', $request->alunos_cursos_controle_id]])
                        ->update(['curso_fim'               => $request->nota_data_termino
                                , 'curso_data_certificacao' => $request->nota_data_certificacao
                                , 'aluno_codigo'            => $this->geraCodigo()
                                , 'aluno_qrcode'            => $this->geraQrCode($url)
                                ]);

        if($notas){
            return redirect(route('alunos.show', $request->aluno_id))->with('success', 'Aluno certificado com sucesso');
        }else{
            return redirect(route('gerar.certificado', $request->alunos_cursos_controle_id))->with('error', 'Erro ao realizar operação, verifique e tente novamente');
        }
    }

    public function formataCPF($cpf){
        $cpf_limpo = preg_replace("/[^0-9]/", "", $cpf);
        $cpf1 = substr($cpf_limpo,0,3);
        $cpf2 = substr($cpf_limpo,3,3);
        $cpf3 = substr($cpf_limpo,6,3);
        $cpf4 = substr($cpf_limpo,9,2);
        if($cpf != "..-"){
            return $cpf = $cpf1.".".$cpf2.".".$cpf3."-".$cpf4; 
        }  
    }

    public function formataCep($cep){
        $cep_limpo = preg_replace("/[^0-9]/", "", $cep);
        $number= substr($cep_limpo,0,5)."-".substr($cep_limpo,0,3);
        return $number;
    }

    public function formataTelefone($number){
        $number_limpo = preg_replace("/[^0-9]/", "", $number);
        $number="(".substr($number_limpo,0,2).") ".substr($number_limpo,2,-4)."-".substr($number_limpo,-4);
        return $number;
    }

    public function imprimirCertificado($controle_id, $aluno_id, $curso_id){

        $pdf = new Fpdf();
        $pdf->AddPage('L');

        $aluno = Aluno::where('aluno_id', $aluno_id)->first();
        $curso = Curso::where('curso_id',$curso_id)->first();
        $aluno_curso = AlunoCurso::where([['aluno_id', '=', $aluno_id]
                                        , ['curso_id', '=', $curso_id]
                                        , ['controle_id', '=', $controle_id]])
                                    ->first();

        $param_valor = ParametroValor::select('pv_valor')->find(2);

        if($param_valor->pv_valor == 'Rui'){
            $pdf->Image('../public/img/certificados/modelo_certificado_rui.png',0,0,302);
        }else{
            $pdf->Image('../public/img/certificados/modelo_certificado_patricia.png',0,0,302);  
        }

        $pdf->SetY(110);
        $pdf->AddFont('Great Vibes','','GreatVibes-Regular.php');
        $pdf->SetFont('Great Vibes', '', 60);
        $pdf->Cell(0,0,utf8_decode(ucwords(strtolower($aluno->aluno_nome))),0,0,'C');

        //frente certificado
        $pdf->AddFont('Montserrat-SemiBold','','Montserrat-SemiBold.php');
        $pdf->SetFont('Montserrat-SemiBold', '', 12);

        $pdf->SetY(130);
        $pdf->Cell(0, 0, utf8_decode("Concluiu o curso de ".strtoupper($curso->curso_nome_curso)),0,0,'C');
       
        $pdf->SetY(135);
        $pdf->Cell(0, 0, utf8_decode("com carga horária de ".$curso->curso_cargaHoraria." na unidade de Ponta Grossa/PR."),0,0,'C');

        $pdf->Text(108, 148, utf8_decode(" Ponta Grossa, "));
        $pdf->Text(140,148, strftime('%d de %B de %Y', strtotime($curso->curso_data_certificacao))) . "";

        //preparando valores
        $data_nasc = date('d/m/Y', strtotime($aluno->aluno_nasc));
        $data_cert = date('d/m/Y', strtotime($aluno_curso->curso_data_certificacao));
        $data_fim = date('d/m/Y', strtotime($aluno_curso->curso_fim));
        $data_inic = date('d/m/Y', strtotime($aluno_curso->curso_inicio));

        //verso certificado
        //lateral esquerda
        $pdf->AddPage('L');
        $pdf->Image('../public/img/certificados/modelo_certificado_verso_empresa_estendido.png',0,0,298);
        
        $pdf->AddFont('Montserrat-SemiBold','','Montserrat-SemiBold.php');
        $pdf->SetFont('Montserrat-SemiBold', '', 10);

        $pdf->Text(10,57, utf8_decode($aluno->aluno_nome));
        $pdf->Text(10,69, utf8_decode($aluno->aluno_rg)); 
        $pdf->Text(92,69, utf8_decode($data_nasc)); 
        $pdf->Text(10,80, utf8_decode($curso->curso_nome_curso)); 
        $pdf->Text(92,92, utf8_decode($curso->curso_cargaHoraria)); 
        $pdf->Text(10,92, utf8_decode($data_inic." à ".$data_fim));    
        
        //formatando cpf
        $pdf->Text(49,69, $this->formataCPF($aluno->aluno_cpf));

        //código
        $pdf->SetFont('Montserrat-SemiBold', '', 14);
        $pdf->Text(195,48, $aluno_curso->aluno_protocolo); 

        //lateral direita
        $pdf->SetFont('Montserrat-SemiBold', '', 8);
        $pdf->Text(222,90.3, utf8_decode($data_cert."."));
        $pdf->Text(260,90.3, $aluno_curso->aluno_codigo);

        //qrcode 
        $pdf->Image('../public/img/qr_code/'.$aluno_curso->aluno_qrcode,257,31,24);

        //variabveis de controle para posicionamento dos módulos
        $x1_linha = 168;
        $y1_linha = 105;
        $x2_linha = 7;
        $y2_linha = 105;

        for($i = 0; $i < 10; $i++){ 
            $pdf->Line($x1_linha,$y1_linha,$x2_linha,$y2_linha);
            $y1_linha = $y1_linha + 5;
            $y2_linha = $y2_linha + 5;
        }


        //buscando modulos
        $modulos = DB::table('alunos_cursos')
                        ->select('modulos.modulo_descricao')
                        ->join('cursos_modulos', 'cursos_modulos.curso_id', '=', 'alunos_cursos.curso_id')
                        ->join('modulos', 'modulos.modulo_id', '=', 'cursos_modulos.modulo_id')
                        ->where('alunos_cursos.controle_id', $controle_id)
                        ->get();
        
        $x = 10;
        $y = 99;
        $x_n = 105;
        $y_n = 99;
        $y_notas = 104;
        $pdf->SetFont('Montserrat-SemiBold', '', 10);
        
        foreach($modulos as $modulo){
            $y = $y + 5;
            $y_n = $y_n + 5;
            $pdf->Text($x,$y, utf8_decode($modulo->modulo_descricao));
        }

        $dados_finais = DB::table('notas')
                                ->select('notas.nota_observacao'
                                       , 'notas.nota_frequencia')
                                ->where('notas.alunos_cursos_controle_id', $controle_id)
                                ->first();     

        //frequencia
        $pdf->Text(40,160.5,$dados_finais->nota_frequencia.'%');

        //mensagem abaixo da tabela
        if($param_valor = ParametroValor::select('pv_valor')->find(5)){
            $pdf->SetFontSize(8);
            $pdf->Text(10,167,utf8_decode($param_valor->pv_valor)); 
        }
        
        //observação
        $pdf->SetFontSize(7);
        $pdf->SetXY(176,150);
        $pdf->MultiCell(113,3,utf8_decode($dados_finais->nota_observacao),0,1);
        $pdf->SetXY(0,0);

        
        //gerando carteirinha
        $pdf->AddPage('L');
        $pdf->Image('../public/img/carteirinhas/carteirinha_frente.png',5,5,90,60);

        $pdf->SetTextColor(255,255,0);
        $pdf->SetFont('Montserrat-SemiBold', '', 8);

        if(strlen($curso->curso_nome_curso) <= 30){
            $pdf->Text(10,23, utf8_decode(ucwords($curso->curso_nome_curso)));
        }else{
            $pdf->Text(9,22.8, ucwords(str_replace(' - Reciclagem','',str_replace('erador de','. ',str_replace('escavadeira', '', utf8_decode($curso->curso_nome_curso))))));
        }       

        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Montserrat-SemiBold', '', 7);
        $pdf->Text(11,28, utf8_decode($aluno->aluno_nome));
        $pdf->Text(15,34.5, utf8_decode($aluno->aluno_rg));
        $pdf->Text(40,34.5, $this->formataCPF($aluno->aluno_cpf));  

        $curso_id = $curso->curso_id;

        $pdf->SetFont('Montserrat-SemiBold', '', 4);
        $pdf->Text(11,57.5, utf8_decode('Data Nascimento')); 
        $pdf->Text(30,57.5, utf8_decode('Data Emissão')); 
        $pdf->Text(46,57.5, utf8_decode('Cidade/Estado')); 
        $pdf->Text(13.5,59.5, $data_nasc); 
        $pdf->Text(31,59.5, $data_cert); 
        $pdf->Text(45.5,59.5, 'Ponta Grossa/PR');  

        $pdf->Image('../public/img/carteirinhas/carteirinha_verso.png',95,5,90,60);

        $x = 11;
        $y = 40.5;
        $x1 = 21;
        $pdf->SetFont('Montserrat-SemiBold', '', 6);
        $v_i = 0;

        foreach($modulos as $modulo){
            $v_i++;
            $y = $y + 2;
            $pdf->Text($x,$y, utf8_decode($modulo->modulo_descricao));
            if($v_i >= 6){
                $y = $y -4;
                $x = 37;
            }
        }

        //código
        $pdf->SetFont('Montserrat-SemiBold', '', 7);
        $pdf->Text(119,24, $aluno_curso->aluno_protocolo); 
        $pdf->Image('../public/img/qr_code/'.$aluno_curso->aluno_qrcode,156,8,28);
        $pdf->SetFont('Montserrat-SemiBold', '', 5.7);

        $pdf->SetXY(100,30.5);
        $pdf->MultiCell(50,2.3,utf8_decode($dados_finais->nota_observacao),0,1);
        $pdf->SetXY(0,0);
         
        return $pdf->Output('d', 'certificado_'.str_replace(" ","_",strtolower($aluno->aluno_nome)).'.pdf');
    }

    public function imprimirContrato($contrato_id, $controle_id, $aluno_id, $curso_id){

        $contrato = Contrato::where('cont_id', $contrato_id)->first();
        $aluno = Aluno::where('aluno_id', $aluno_id)->first();
        $curso = Curso::where('curso_id', $curso_id)->first();
        $aluno_curso = AlunoCurso::where('controle_id', $controle_id)->first();

        $cnpj = ParametroValor::select('pv_valor')->find(7);
        $razao_social = ParametroValor::select('pv_valor')->find(8);
        $ie = ParametroValor::select('pv_valor')->find(9);
        $end = ParametroValor::select('pv_valor')->find(10);
        $contato = ParametroValor::select('pv_valor')->find(11);

        $clausulas = ParametroValor::select('pv_valor')->find(6);

        $pdf = new Fpdf();
        $pdf->AddPage('P');

        $pdf->AliasNbPages();

        $pdf->AddFont('arial','','arial.php');
        $pdf->SetFont('arial', '', 10);

        $pdf->Cell(0,10,utf8_decode('CONTRATO PARTICULAR DE PRESTAÇÃO DE SERVIÇOS DE CURSOS'),0,0,'C');
        $pdf->Text(11,25,utf8_decode('Pelo presente instrumento particular de contrato de prestação de serviços que fazem entre si.'));

        $pdf->SetXY(10,28);
        $pdf->MultiCell(180,4,utf8_decode('CONTRATADA: '.$razao_social->pv_valor.', CNPJ:'.$cnpj->pv_valor.' - IE: '.$ie->pv_valor.', com sede na '.$end->pv_valor.', representado neste ato por seu diretor e/ou preposto ao final identicado e assinado.'),0, 'J');

        $pdf->SetXY(10,43);
        $pdf->MultiCell(180,4,utf8_decode('CONTRATANTE: '.$aluno->aluno_nome.
                                   ($this->formataCPF($aluno->aluno_cpf) ? ', CPF: '.$this->formataCPF($aluno->aluno_cpf).'' : ', ').
                                   (!empty($aluno->aluno_rg) ? ', RG: '.$aluno->aluno_rg.', ' : '').
                                   ' Data de Nascimento: '.date('d/m/Y', strtotime($aluno->aluno_nasc)).
                                   ', Residente em: '.$aluno->aluno_end.''.($aluno->aluno_cep != '-' or $aluno->aluno_cep == '' ? ', CEP '.$this->formataCep($aluno->aluno_cep) : '').
                                   ', Cidade: '.$aluno->aluno_cidade.                                   
                                   ', Estado: '.$aluno->aluno_estado.
                                   ', Fone: '.$this->formataTelefone($aluno->aluno_cel)),0, 'J');
                      
        if(!empty($aluno->aluno_resp)){
        $pdf->SetXY(10,55);
        $pdf->MultiCell(500,11,utf8_decode('Em caso do contratante ser menor de idade, este será representado por:'),0, 'J');
        $pdf->SetXY(10,60);
        $pdf->MultiCell(500,11,utf8_decode('RESPONSÁVEL: '.$aluno->aluno_resp.
                                            ($aluno->aluno_cpf_resp != '..-' or $aluno->aluno_cpf_resp != '' ? ', CPF: '.$aluno->aluno_cpf_resp.'' : '').
                                            (!empty($aluno->aluno_rg_resp) ? ', RG: '.$aluno->aluno_rg_resp.'. ' : '.')),0, 'J');
        }

        //delimitador
        //$pdf->Line(10,65,200,65);
        
        $pdf->SetXY(10,70);
        $pdf->MultiCell(0,5,utf8_decode('Firmam o presente contrato pelas cláusulas que seguem:'),0, 'J');

        //escreve as clausulas
        $pdf->SetXY(10,80);
        $pdf->MultiCell(0,5,utf8_decode($clausulas->pv_valor),0, 'L');

        $parcela = DB::table('parcelas')
                            ->select(DB::raw('count(num_parcela) as num_parcela')
                                   , 'valor_parcela')
                            ->where('contrato_id', $contrato_id)->first();

        $pdf->Ln();
        $pdf->Ln();

        $pdf->SetFontSize(8);
        $width_cell=array(23,23,20,23,23,27,23,27,24);
        $pdf->SetFillColor(255,255,255);
        $pdf->Cell($width_cell[0],8,utf8_decode('Taxa matrícula'),1,0,'C',true);
        $pdf->Cell($width_cell[1],8,utf8_decode('Material didático'),1,0,'C',true);
        $pdf->Cell($width_cell[2],8,'Valor parcela',1,0,'C',true);
        $pdf->Cell($width_cell[4],8,'Valor total curso',1,0,'C',true);
        $pdf->Cell($width_cell[5],8,'Parcela com desc.',1,0,'C',true);
        $pdf->Cell($width_cell[6],8,'Qtd. de parcelas',1,0,'C',true);
        $pdf->Cell($width_cell[7],8,'Data de vencimento',1,0,'C',true);
        $pdf->Cell($width_cell[8],8,'Total do desconto',1,0,'C',true);

        $pdf->Ln();

        $pdf->Cell($width_cell[0],8,($contrato->cont_matricula != null ? str_replace('.',',',$contrato->cont_matricula) : "0,00"),1,0,'C',true);
        $pdf->Cell($width_cell[1],8,($contrato->cont_materail != null ? str_replace('.',',',$contrato->cont_materail) : "0,00"),1,0,'C',true);

        $pdf->Cell($width_cell[2],8,($parcela->valor_parcela != null ? str_replace('.',',',$parcela->valor_parcela) : "0,00"),1,0,'C',true);
        
        $pdf->Cell($width_cell[4],8,($contrato->cont_valor_integral != null ? str_replace('.',',',$contrato->cont_valor_integral) : "0,00"),1,0,'C',true);
        $pdf->Cell($width_cell[5],8,str_replace('.',',',round($contrato->cont_valor_integral / $parcela->num_parcela,2)),1,0,'C',true);
        $pdf->Cell($width_cell[6],8,str_replace('.',',',$parcela->num_parcela),1,0,'C',true);
        $pdf->Cell($width_cell[7],8,str_replace('.',',',$contrato->cont_data_vencimento),1,0,'C',true);
        $pdf->Cell($width_cell[8],8,($contrato->cont_vDesconto != null ? str_replace('.',',',$contrato->cont_vDesconto) : "0,00"),1,0,'C',true);

        $pdf->Ln();

        $pdf->SetFontSize(10);
        $pdf->Cell(70,8,'','B',0,'L',true);
        $pdf->Ln();
        $pdf->Cell(70,8,utf8_decode($aluno->aluno_nome),'',0,'L',true);

        if($aluno->aluno_resp != null){

            $pdf->Ln();
            $pdf->Ln();

            $pdf->Cell(70,8,'','B',0,'L',true);
            $pdf->Ln();
            $pdf->Cell(70,8,utf8_decode('Responsável: '.$aluno->aluno_resp),'',0,'L',true);
        }

        $pdf->Ln();
        $pdf->Ln();

        $pdf->Cell(70,8,'','B',0,'L',true);
        $pdf->Ln();
        $pdf->Cell(70,8,utf8_decode($razao_social->pv_valor),'',0,'L',true);
        
        $pdf->Ln();
        
        $pdf->Cell(0,20,strtoupper(strftime('%d de %B de %Y', strtotime($contrato->cont_data))),0,0,'C');

        return $pdf->Output('d', 'contrato_'.$contrato_id.'_'.str_replace(" ","_",strtolower($aluno->aluno_nome)).'.pdf');

    }
    
}
