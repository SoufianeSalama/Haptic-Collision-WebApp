<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

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
                $oAnswerObject->result = false;
                echo json_encode($oAnswerObject);
            }
            else{
                $command = escapeshellcmd('/home/hapticcollisionadmin/scripts/Script-Python/venv_linux/bin/python /home/hapticcollisionadmin/scripts/Script-Python/bin/orthoplanner.py -e ' . (string)$sPatientEAD);
                $output = shell_exec($command);
                //echo get_current_user();

                if (strpos($output, 'Data exported succesfully')){
                    // Get result data from table Clinical Measurements
                    $oAnswerObject->result = true;
                    $oAnswerObject->algorithm = true;

                    $aResultAlgorithm = $this->Patient_Model->getResultAlgorithm($sPatientEAD);
                    $oAnswerObject->d_maxilla_advancement = $aResultAlgorithm->maxilla_advancement_predicted;
                    $oAnswerObject->s_maxilla_pieces = $aResultAlgorithm->maxilla_pieces_predicted ;
                    $oAnswerObject->s_maxilla_anterior = $aResultAlgorithm->maxilla_anterior_predicted ;
                    $oAnswerObject->s_maxilla_posterior = $aResultAlgorithm->maxilla_posterior_predicted ;
                    $oAnswerObject->s_maxilla_midline_rotation = $aResultAlgorithm->maxilla_midline_rotation_predicted ;
                    $oAnswerObject->s_mandible_advancement_setback = $aResultAlgorithm->mandible_advancement_setback_predicted ;
                    $oAnswerObject->d_chin_advancement = $aResultAlgorithm->chin_advancement_predicted ;
                    $oAnswerObject->d_chin_intrusion_extrusion = $aResultAlgorithm->chin_intrusion_extrusion_predicted ;

                    echo json_encode($oAnswerObject);

                }else{
                    $oAnswerObject->algorithm = false;
                    $oAnswerObject->result = false;

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
