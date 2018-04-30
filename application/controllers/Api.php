<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    /*public function allPatients(){
        $iDocterId = 1;
        $this->load->model('Patient_Model');
        $aPatients = $this->Patient_Model->getMyPatients($iDocterId);
        header('Access-Control-Allow-Origin: *', false);
        echo json_encode($aPatients);
    }

    public function patientProfile($sPatientEad){
        $this->load->model('Patient_Model');
        $aPatient = $this->Patient_Model->getPatient($sPatientEad)->result();
        header('Access-Control-Allow-Origin: *', false);
        echo json_encode($aPatient);
    }*/

    public function runAlgorithm(){
        $sPatientEAD = $this->input->get('patientead');
        // Only run algorithm when there is a row in Radiograph Analayze and Clinical Measurement tables.
        $this->load->model('Patient_Model');
        if (!$this->Patient_Model->newPatientCheckEad($sPatientEAD)){
            $bResultClinicalMeas = $this->Patient_Model->checkClinincalMeasRow($sPatientEAD);
            $bResultRadiographAnalyze = $this->Patient_Model->checkRadiographAnalyzeRow($sPatientEAD);

            $oAnswerObject = new stdClass();
            $oAnswerObject->patientead = $sPatientEAD;
            $oAnswerObject->clinicalmeas = $bResultClinicalMeas;
            $oAnswerObject->radiographanalyze = $bResultRadiographAnalyze;

            if (!$oAnswerObject->clinicalmeas || !$oAnswerObject->radiographanalyze){
                echo json_encode($oAnswerObject);
            }
            else{
                $command = escapeshellcmd('/home/hapticcollisionadmin/scripts/Script-Python/venv_linux/bin/python /home/hapticcollisionadmin/scripts/Script-Python/bin/orthoplanner.py -e ' . (string)$sPatientEAD);
                $output = shell_exec($command);
                //echo get_current_user();

                if (strpos($output, 'Algorithm succeeded')){
                    // Get result data from table Clinical Measurements
                    $oAnswerObject->algorithm = true;

                    $aResultAlgorithm = $this->Patient_Model->getResultAlgorithm($sPatientEAD);

                    $oAnswerObject->d_maxilla_advancement = $aResultAlgorithm[""];
                    $oAnswerObject->s_maxilla_pieces = $aResultAlgorithm[""];
                    $oAnswerObject->s_maxilla_anterior = $aResultAlgorithm[""];
                    $oAnswerObject->s_maxilla_posterior = $aResultAlgorithm[""];
                    $oAnswerObject->s_maxilla_midline_rotation = $aResultAlgorithm[""];
                    $oAnswerObject->s_mandible_advancement_setback = $aResultAlgorithm[""];
                    $oAnswerObject->d_chin_advancement = $aResultAlgorithm[""];
                    $oAnswerObject->d_chin_intrusion_extrusion = $aResultAlgorithm[""];

                    echo json_encode($oAnswerObject);

                }else{
                    $oAnswerObject->algorithm = false;
                    echo json_encode($oAnswerObject);
                }
            }
        }
        else{
            http_response_code(404);
            //die();
        }
    }

}
