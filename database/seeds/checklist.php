<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\CheckList as Check;

class checklist extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    $array = array(
    // array("val0"=>"Code","val1"=>"Descirption","val2"=>"S/R","val3"=>"Phase"),
    array("val0"=>"SA1","val1"=>"Send Packet to CL (FA-Dated,1696,827, and Hippa)","val2"=>"Single","val3"=>""),
    array("val0"=>"SA2","val1"=>"Receive FA, Hippa, 827, and 1696","val2"=>"Single","val3"=>""),
    array("val0"=>"SB1","val1"=>"Is initial claim filed? - mark done if at initial (enter on Case History Tab) OR delete and set checklist for proper level","val2"=>"Single","val3"=>"1"),
    array("val0"=>"SA3","val1"=>"Fax 1695, 1696, 827and FA to DO","val2"=>"Single","val3"=>""),
    array("val0"=>"SA4","val1"=>"Send VC welcome letter, SSBI Disability Questionnaire, and copy of signed FA","val2"=>"Single","val3"=>""),
    array("val0"=>"SB2","val1"=>"Receive DE info letter","val2"=>"Single","val3"=>"1"),
    array("val0"=>"SB4","val1"=>"Check in with DE/CL - initial claim","val2"=>"Repeat","val3"=>"1"),
    array("val0"=>"SB9","val1"=>"Receive Initial Denial","val2"=>"Single","val3"=>"1"),
    array("val0"=>"SA6","val1"=>"1695 Confirmation Received - Refax Rep forms to DO if not","val2"=>"Single","val3"=>""),
    array("val0"=>"SB5","val1"=>"Call CL to remind about CE - initial claim","val2"=>"Single","val3"=>"1"),
    array("val0"=>"SB7","val1"=>"File Initial App online, w/client on phone. Fax app conf pages, cover letter #47, and rep forms to the DO. AND Send ltr #41 to CL.","val2"=>"Single","val3"=>"1"),
    array("val0"=>"SB8","val1"=>"Remind CL to complete DDS work history report or function report","val2"=>"Single","val3"=>"1"),
    array("val0"=>"SC1","val1"=>"File Request for Reconsideration - (enter on Case History Tab) AND Fax 827, Appeal confirmation, and rep forms to DO","val2"=>"Single","val3"=>"2"),
    array("val0"=>"SC2","val1"=>"Receive DE info letter - recon","val2"=>"Single","val3"=>"2"),
    array("val0"=>"SC4","val1"=>"Check in with DE/CL - recon claim","val2"=>"Repeat","val3"=>"2"),
    array("val0"=>"SC9","val1"=>"Received Recon denial - (enter on Case History Tab)","val2"=>"Single","val3"=>"2"),
    array("val0"=>"SC5","val1"=>"Call CL to remind about CE - recon","val2"=>"Single","val3"=>"2"),
    array("val0"=>"SD1","val1"=>"File Request for Hearing - (enter on Case History Tab) AND Fax 827, Appeal confirmation, and rep forms to DO","val2"=>"Single","val3"=>"3"),
    array("val0"=>"SD3","val1"=>"Receive VTC letter","val2"=>"Single","val3"=>"3"),
    array("val0"=>"SD6","val1"=>"Download ODAR file or Copy if Paper File","val2"=>"Single","val3"=>"3"),
    array("val0"=>"SD8","val1"=>"Medical Records- Follow Up and Receive","val2"=>"Single","val3"=>"3"),
    array("val0"=>"SE2","val1"=>"Hearing scheduled with ODAR yet??**when scheduled, select done to trigger pre- hearing checklist**","val2"=>"Single","val3"=>"3"),
    array("val0"=>"SE3","val1"=>"Get MSS form(s) completed by CL's doctor(s)","val2"=>"Single","val3"=>"3"),
    array("val0"=>"SE4","val1"=>"Send HP forms, Associate co rep forms, and hearing letters with Mapquest Directions to CL","val2"=>"Single","val3"=>"3"),
    array("val0"=>"SE5","val1"=>"Receive HP forms from CL,ensure correctness, and ERE to ODAR","val2"=>"Single","val3"=>"3"),
    array("val0"=>"SE6","val1"=>"Pre-PHI","val2"=>"Single","val3"=>"3"),
    array("val0"=>"SE8","val1"=>"Order MER before Hearing (see records tab, ODAR disc, SSBI,notes)","val2"=>"Single","val3"=>"3"),
    array("val0"=>"SE9","val1"=>"Complete PHI","val2"=>"Single","val3"=>"3"),
    array("val0"=>"SF1","val1"=>"Hearing-VC","val2"=>"Single","val3"=>"3"),
    array("val0"=>"SF2","val1"=>"Hearing","val2"=>"Single","val3"=>"3"),
    array("val0"=>"SF3","val1"=>"Receive Hearing Decision","val2"=>"Single","val3"=>"3"),
    array("val0"=>"SG1","val1"=>"FILE AC appeal*****OR**SEND BC A MESSAGE TO CLOSE CASE OR START NEW CLAIM IF NOT","val2"=>"Single","val3"=>"4"),
    array("val0"=>"SG2","val1"=>"Check in with AC on file request","val2"=>"Single","val3"=>"4"),
    array("val0"=>"SG5","val1"=>"Check with AC about decision","val2"=>"Single","val3"=>"4"),
    array("val0"=>"SG6","val1"=>"Receive AC decision","val2"=>"Single","val3"=>"4"),
    array("val0"=>"SH1","val1"=>"If Decision is favorable Send congrats letter and costs bill","val2"=>"Single","val3"=>""),
    array("val0"=>"SH2","val1"=>"NOA received -  (enter on Case History Tab)","val2"=>"Single","val3"=>""),
    array("val0"=>"SH3","val1"=>"Send 1st costs letter to CL, call if problems, please refer","val2"=>"Single","val3"=>""),
    array("val0"=>"SH4","val1"=>"Send costs letter, call if issues, please refer","val2"=>"Single","val3"=>""),
    array("val0"=>"SH8","val1"=>"Back pay and Atty fee paid yet?","val2"=>"Single","val3"=>""),
    array("val0"=>"SK1","val1"=>"Response to Objections Due","val2"=>"Single","val3"=>""),
    array("val0"=>"SK2","val1"=>"Judgment Due","val2"=>"Single","val3"=>""),
    array("val0"=>"SK3","val1"=>"Call CL about outcome","val2"=>"Single","val3"=>""),
    array("val0"=>"SM3","val1"=>"Help CL get MSS from Medical provider","val2"=>"Single","val3"=>""),
    array("val0"=>"SM4","val1"=>"MSS BACK? If yes, be sure to submit. If Supportive request MER. IF not supportive schedule W attorney to close.","val2"=>"Single","val3"=>""),
    array("val0"=>"SO1","val1"=>"Check in W CL (Treatment, meds, work, medicaid?)-NEVER CLOSE ALWAYS RESET","val2"=>"Repeat","val3"=>""),
    array("val0"=>"SP1","val1"=>"Close Case in Needles???Are Costs paid/fees paid?","val2"=>"Single","val3"=>"5"),
    array("val0"=>"ST4","val1"=>"Send CL status update sheet(HCD) - after R/H file - Do they need Dis ?'aire","val2"=>"Repeat","val3"=>"3"),
    array("val0"=>"SU1","val1"=>"Send CL call-in letter","val2"=>"Single","val3"=>""),
    array("val0"=>"SU2","val1"=>"Send call-in deadline letter","val2"=>"Single","val3"=>""),
    array("val0"=>"SU3","val1"=>"Notify ATTY is CL has not called in","val2"=>"Single","val3"=>""),
    array("val0"=>"SU4","val1"=>"TO DO - Generic","val2"=>"Single","val3"=>""),
    array("val0"=>"SU5","val1"=>"Double check appeal and send 'I filed Recon Letter to CL'","val2"=>"Single","val3"=>"2"),
    array("val0"=>"SU6","val1"=>"Double check appeal and send 'I filed RH letter to CL'","val2"=>"Single","val3"=>"3"),
    array("val0"=>"SY1","val1"=>"Hearing on----- Brief?","val2"=>"Single","val3"=>"3"),
    array("val0"=>"SY4","val1"=>"Fax Request to DO for all prior claims be associated- document 118","val2"=>"Single","val3"=>"3"),
    array("val0"=>"SY5","val1"=>"Remind CL of Hearing Tomorrow","val2"=>"Single","val3"=>"3"),
    array("val0"=>"BBB","val1"=>"TD From Atty","val2"=>"Single","val3"=>""),
);


	 
		foreach ($array as $user) {
		 	$checklist = new Check();
		 	$checklist->code = $user['val0']; 
		 	$checklist->description = $user['val1']; 
		 	$checklist->sr = $user['val2']; 
		 	$checklist->phase = $user['val3']; 
		 	$checklist->save();
		 	echo '.';
		}

    }
}
