<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Soufiane
 * Date: 25/03/2018
 * Time: 18:40
 */

if ( !function_exists("downloadExcelData")){
    function downloadExcelData($sFileName){
        try{
            $CI =& get_instance();
            $CI->load->helper('download');
            force_download("./uploads/" . $sFileName, NULL);
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }
}

if ( !function_exists("uploadExcelData"))
{
    function uploadExcelData(){
        $config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'xlsx';
        $config['max_size']             = 100;
        $config['overwrite']             = TRUE;

        $CI =& get_instance();
        $CI->load->library('upload', $config);
        if ( ! $CI->upload->do_upload('frmUploadData'))
        {
            $error = array('error' => $CI->upload->display_errors());
            return false;
        }
        else
        {
            $data = array('upload_data' => $CI->upload->data());
            return $data;
        }
    }
}

if ( !function_exists("parseExcelData")){
     function parseExcelData($aFileData){
        //$sFilePath =  $aFileData["full_path"];
        $sFilePath =  $aFileData;

        require_once "./application/third_party/PHPExcel-1.8/Classes/PHPExcel.php";

        $oExcelReader = PHPExcel_IOFactory::createReaderForFile($sFilePath);
        $oExcelOcject = $oExcelReader->load($sFilePath);
        $oWorksheet = $oExcelOcject->getActiveSheet();
        return worksheetReader($oWorksheet);
    }
}

if ( !function_exists("worksheetReader"))
{
    function worksheetReader($oWorksheet)
    {
        require_once "./application/models/RadiographAnalyze.php";

        $oRadiographAnalyze = new RadiographAnalyze();
        $iLastRow = $oWorksheet->getHighestRow();

        for ($iRow = 1; $iRow <= $iLastRow; $iRow++) {
            $sMeasurementType = $oWorksheet->getCell('A' . $iRow);
            $dMeasurementValue = $oWorksheet->getCell('D' . $iRow)->getValue();;

            switch ($sMeasurementType) {
                case "I1u-NF":
                    $oRadiographAnalyze->i_i1u_nf = $dMeasurementValue;
                    break;
                case "I1l-MP":
                    $oRadiographAnalyze->i_i1i_mp = $dMeasurementValue;
                    break;
                case "6u-NF":
                    $oRadiographAnalyze->d_6u_nf = $dMeasurementValue;
                    break;
                case "6l-MP":
                    $oRadiographAnalyze->d_6l_mp = $dMeasurementValue;
                    break;
                case "ANS-PNS":
                    $oRadiographAnalyze->d_ans_pns = $dMeasurementValue;
                    break;
                case "N-ANS":
                    $oRadiographAnalyze->d_n_ans =$dMeasurementValue;
                    break;
                case "ANS-Gn":
                    $oRadiographAnalyze->d_ans_gn = $dMeasurementValue;
                    break;
                case "ar-Go":
                    $oRadiographAnalyze->d_ar_go_1 = $dMeasurementValue;
                    break;
                case "Go-Pog":
                    $oRadiographAnalyze->d_go_pog = $dMeasurementValue;
                    break;
                case "ar-Pt":
                    $oRadiographAnalyze->d_ar_pt = $dMeasurementValue;
                    break;
                case "Pt-N":
                    $oRadiographAnalyze->d_pt_n = $dMeasurementValue;
                    break;
                case "N-S":
                    $oRadiographAnalyze->d_n_s = $dMeasurementValue;
                    break;
                case "S-ar":
                    $oRadiographAnalyze->d_s_ar = $dMeasurementValue;
                    break;
                case "ar-Go.":
                    $oRadiographAnalyze->d_ar_go_2 = $dMeasurementValue;
                    break;
                case "Go-Me":
                    $oRadiographAnalyze->d_go_me = $dMeasurementValue;
                    break;
                case "overjet":
                    $oRadiographAnalyze->d_overjet2 = $dMeasurementValue;
                    break;
                case "overbite":
                    $oRadiographAnalyze->d_overbite2 = $dMeasurementValue;
                    break;
                case "Go-Me:N-S":
                    $oRadiographAnalyze->d_go_me_n_s = $dMeasurementValue;
                    break;
                case "S-Go:N-Me":
                    $oRadiographAnalyze->d_s_go_n_me = $dMeasurementValue;
                    break;
                case "UFH:LFH":
                    $oRadiographAnalyze->d_ufh_lfh = $dMeasurementValue;
                    break;
                case "Ns-Pog'":
                    $oRadiographAnalyze->d_ns_pog = $dMeasurementValue;
                    break;
                case "Gl-Gl'":
                    $oRadiographAnalyze->d_gl_gl = $dMeasurementValue;
                    break;
                case "A-Sn":
                    $oRadiographAnalyze->d_a_sn = $dMeasurementValue;
                    break;
                case "Ls1u-Ls":
                    $oRadiographAnalyze->d_ls1u_ls = $dMeasurementValue;
                    break;
                case "Li1l-Li":
                    $oRadiographAnalyze->d_li1l_li = $dMeasurementValue;
                    break;
                case "B-Sm":
                    $oRadiographAnalyze->d_b_sm = $dMeasurementValue;
                    break;
                case "Pog-Pog'":
                    $oRadiographAnalyze->d_pog_pog = $dMeasurementValue;
                    break;
                case "Gl'-Sn":
                    $oRadiographAnalyze->d_gl_sn = $dMeasurementValue;
                    break;
                case "Sn-Me'":
                    $oRadiographAnalyze->d_sn_me = $dMeasurementValue;
                    break;
                case "Sn-sto":
                    $oRadiographAnalyze->d_sn_sto = $dMeasurementValue;
                    break;
                case "sto-Me'":
                    $oRadiographAnalyze->d_sto_me = $dMeasurementValue;
                    break;
                case "LLL":
                    $oRadiographAnalyze->d_lll = $dMeasurementValue;
                    break;
                case "Interlab":
                    $oRadiographAnalyze->d_interlab = $dMeasurementValue;
                    break;
                case "CL":
                    $oRadiographAnalyze->d_cl = $dMeasurementValue;
                    break;
                case "Gl'-Sn:Sn-Me'":
                    $oRadiographAnalyze->d_gl_sn_sn_me = $dMeasurementValue;
                    break;
                case "Sn-sto:sto-Me'":
                    $oRadiographAnalyze->d_sn_sto_sto_me = $dMeasurementValue;
                    break;
                case "S-Go":
                    $oRadiographAnalyze->d_s_go = $dMeasurementValue;
                    break;
                case "N-Me":
                    $oRadiographAnalyze->d_n_me = $dMeasurementValue;
                    break;
                case "PNS-N":
                    $oRadiographAnalyze->d_pns_n = $dMeasurementValue;
                    break;
                case "N-A":
                    $oRadiographAnalyze->d_n_a = $dMeasurementValue;
                    break;
                case "N-B":
                    $oRadiographAnalyze->d_n_b = $dMeasurementValue;
                    break;
                case "N-Pog":
                    $oRadiographAnalyze->d_n_pog = $dMeasurementValue;
                    break;
                case "B-PogMP":
                    $oRadiographAnalyze->d_b_pogmp = $dMeasurementValue;
                    break;
                case "1u-NPog":
                    $oRadiographAnalyze->d_1u_npog = $dMeasurementValue;
                    break;
                case "1u-APog":
                    $oRadiographAnalyze->d_1u_apog = $dMeasurementValue;
                    break;
                case "1l-NPog":
                    $oRadiographAnalyze->d_1l_npog = $dMeasurementValue;
                    break;

                case "Ls-NsPog'":
                    $oRadiographAnalyze->d_ls_nspog = $dMeasurementValue;
                    break;
                case "Li-NsPog'":
                    $oRadiographAnalyze->d_li_nspog = $dMeasurementValue;
                    break;
                case "Pog'-Gl'Sn/Sn12°":
                    $oRadiographAnalyze->d_pog_gl_sn_sn12 = $dMeasurementValue;
                    break;
                case "SnPerp-Ls":
                    $oRadiographAnalyze->d_sn_perp_ls = $dMeasurementValue;
                    break;
                case "SnPerp-Li":
                    $oRadiographAnalyze->d_sn_perp_li = $dMeasurementValue;
                    break;

                case "SnPerp-Pog'":
                    $oRadiographAnalyze->d_snperp_pog = $dMeasurementValue;
                    break;
                case "Wits":
                    $oRadiographAnalyze->d_wits = $dMeasurementValue;
                    break;
                case "Max1-NF":
                    $oRadiographAnalyze->d_max1_nf = $dMeasurementValue;
                    break;
                case "Max1-SN":
                    $oRadiographAnalyze->d_max1_sn = $dMeasurementValue;
                    break;
                case "Upper Occ. Pl.-T.V.":
                    $oRadiographAnalyze->d_upper_occ_pl_tv = $dMeasurementValue;
                    break;
                case "Max1-Upper Occ. Pl.":
                    $oRadiographAnalyze->d_max1_upper_occ_pl = $dMeasurementValue;
                    break;
                case "Mand1-Lower Occ. Pl.":
                    $oRadiographAnalyze->d_mand1_lower_occ_pl = $dMeasurementValue;
                    break;
                case "Mand1-MP":
                    $oRadiographAnalyze->d_mand1_mp = $dMeasurementValue;
                    break;
                case "II":
                    $oRadiographAnalyze->d_ii = $dMeasurementValue;
                    break;
                case "arGoMe":
                    $oRadiographAnalyze->d_ar_go_me = $dMeasurementValue;
                    break;
                case "SNA":
                    $oRadiographAnalyze->d_sna = $dMeasurementValue;
                    break;
                case "SNB":
                    $oRadiographAnalyze->d_snb = $dMeasurementValue;
                    break;
                case "ANB":
                    $oRadiographAnalyze->d_anb = $dMeasurementValue;
                    break;

                case "SNGoMe":
                    $oRadiographAnalyze->d_s_n_go_me = $dMeasurementValue;
                    break;
                case "MP-HP":
                    $oRadiographAnalyze->d_mp_hp = $dMeasurementValue;
                    break;
                case "SpP-T2Me":
                    $oRadiographAnalyze->d_sp_p_t2me = $dMeasurementValue;
                    break;
                case "SNPog":
                    $oRadiographAnalyze->d_s_n_pog = $dMeasurementValue;
                    break;
                case "N-A-Pog":
                    $oRadiographAnalyze->d_n_a_pog = $dMeasurementValue;
                    break;
                case "Gl'SnPog'":
                    $oRadiographAnalyze->d_gl_sn_pog = $dMeasurementValue;
                    break;
                case "CotgSnLs":
                    $oRadiographAnalyze->d_cotg_sn_ls = $dMeasurementValue;
                    break;
                case "LCT":
                    $oRadiographAnalyze->d_lct = $dMeasurementValue;
                    break;
            }
        }
        return $oRadiographAnalyze;
    }
}
