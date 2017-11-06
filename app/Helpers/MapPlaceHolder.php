<?php

namespace app\Helpers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use App\Helpers\DateUtils as DateUtil;
use App\Models\Student;
use App\Models\Faculty;
use App\Models\AcademicSession;
use App\Models\Program;
use App\Models\Course;
use App\Models\Visa;
use App\Models\Staff;
use App\Models\StudentContact;

class MapPlaceHolder
{

    /**
     * [getPlaceholder description]
     * @param  [type] $student_id    [student id]
     * @param  [type] $template_body [body of the template]
     * @return [type]                [converted body]
     */
    public static function getPlaceholder($student, $template)
    {
        $body = $template;
        if(is_object($template)){
            $body = $template->message_body;
        }else if(is_array($template)){
            $body = $template['message_body'];
        }
        $student_id = $student;
        if(is_object($student)){
            $student_id = $student->id;
        }else if(is_array($student)){
            $student_id = $student['student_id'];
        }
        $student = Student::find($student_id);
        $student_program = $student->studentProgram->first();
        
        $data = [
            'message_body' => $body,
            'student' => $student,
            'student_id' => $student_id,
            'student_program' => $student_program,
        ];
        $placeholder = Self::mapPlaceHolder($data);
        return $placeholder;
    }

    /**
     * [mapPlaceHolder description]
     * @param  [type] $data [convert placeholder to string]
     * @return [type]       [return body after convert]
     */
    public static function mapPlaceHolder($data)
    {
        $user_id = 0;
        if(count(auth()->user()) > 0){
            $user_id = auth()->user()->id;
        }
        if (!empty($data['letter_template_id']) || !empty($data['message_body'])) {
            // Retrieve data
            if(!empty($data['letter_template_id'])){
                $letter_template = LetterTemplate::find($data['letter_template_id']);
            }

            //Extract the placeholder, then replace it with the actual db fieldname
            $template_body = $data['message_body'];
            if(!empty($letter_template)){
                $template_body = $letter_template['message_body'];
            }
            preg_match_all('/{([^}]*)}/', $template_body, $matches);

            if (!empty($matches[0])) {
                $message_body = $template_body;

                // Default
                $deposit_local = @$data['deposit_local'];
                $deposit_international = @$data['deposit_international'];
                $fee_local = @$data['fee_local'];
                $fee_international = @$data['fee_international'];
                $registered_at = (!empty($data['registered_at'])) ? explode(' - ', $data['registered_at']) : [];
                // $registered_from_at = $data['registered_from_at']; //TODO
                // $registered_to_at = $data['registered_to_at']; //TODO
                $location_id = @$data['location_id'];
                $admissions_status_id = @$data['admissions_status_id'];
                $academic_session_id = @$data['academic_session_id'];
                $student_id = $data['student_id'];
                // $module_id = $data['module_id']; //TODO

                // Retrieve data
                $general_setting = ['address' => 'Cyberjaya', 'website' => 'www.general.com', 'fax_number' => '0398765432', 'phone_number' => '0987654321', 'institution_name' => 'Barracuda Campus'];//GeneralSettings::all(); //TODO
                $location = (!empty($location_id)) ? Campus::find($location_id) : null;
                $faculty = (!empty(@$data['student_program']->faculty_id)) ? Faculty::find(@$data['student_program']->faculty_id) : null;
                $admissions_status = (!empty($admissions_status_id)) ? AdmissionStatus::find($admissions_status_id) : null;
                $academic_session = (!empty($academic_session_id)) ? AcademicSession::find($academic_session_id) : null;
                $visa = Visa::orderBy('visa_expired_at', 'desc')->find(@$data['student']->visa_id);
                $staff = Staff::where('user_id', '=', $user_id)->first();
                $student_address = @$data['student']->address->where('type', ADDRESS_TYPE_PRIMARY)->first();
                // $program_type = ProgramType::find(@$data['student']->program_type_id); //TODO
                $student_contact = StudentContact::where('student_id', '=', @$data['student']->id)->first();

                //Populate value
                //Deposit & First Semester Fee
                if (@$data['student']->international == STUDENT_TYPE_LOCAL) {
                    $letter_data['deposit'] = $deposit_local;
                    $letter_data['fee'] = $fee_local;
                } elseif (@$data['student']->international == STUDENT_TYPE_INTERNATIONAL) {
                    $letter_data['deposit'] = $deposit_international;
                    $letter_data['fee'] = $fee_international;
                }

                //Address
                $address = '';

                if (!empty($student_address)) {
                    $address .= (!empty($student_address->line_1)) ? $student_address->line_1 . '<br/>' : '';
                    $address .= (!empty($student_address->line_2)) ? $student_address->line_2 . '<br/>' : '';
                    $address .= (!empty($student_address->line_3)) ? $student_address->line_3 . '<br/>' : '';
                    $address .= (!empty($student_address->postcode)) ? $student_address->postcode . ' ' : '';
                    $address .= (!empty($student_address->city)) ? $student_address->city . ' ' : '';
                    $address .= (!empty($student_address->state)) ? $student_address->state . '<br/>' : '';
                    $address .= (!empty($student_address->country->name)) ? $student_address->country->name . '<br/>' : '';
                }

                //Parent/Guardian contact
                if (!empty($student_contact)) {
                    $letter_data['contact']['name'] = $student_contact->name;

                    $contact_address = $student_contact->address->first(function ($item, $key) {
                        return $item->type = ADDRESS_TYPE_PRIMARY;
                    });

                    if (!empty($contact_address)) {
                        $letter_data['contact']['address'] = (!empty($contact_address->line_1)) ? $contact_address->line_1 . '<br/>' : '';
                        $letter_data['contact']['address'] .= (!empty($contact_address->line_2)) ? $contact_address->line_2 . '<br/>' : '';
                        $letter_data['contact']['address'] .= (!empty($contact_address->line_3)) ? $contact_address->line_3 . '<br/>' : '';
                        $letter_data['contact']['address'] .= (!empty($contact_address->postcode)) ? $contact_address->postcode . ' ' : '';
                        $letter_data['contact']['address'] .= (!empty($contact_address->city)) ? $contact_address->city . ' ' : '';
                        $letter_data['contact']['address'] .= (!empty($contact_address->state)) ? $contact_address->state . '<br/>' : '';
                        $letter_data['contact']['address'] .= (!empty($contact_address->country->name)) ? $contact_address->country->name . '<br/>' : '';
                    }
                } else {
                    $letter_data['contact'] = null;
                }

                //Others
                $letter_data['registered_from_at'] = (!empty($registered_at[0])) ? $registered_at[0] : '';
                $letter_data['registered_to_at'] = (!empty($registered_at[1])) ? $registered_at[1] : '';
                $letter_data['guarantee_amount'] = @$data['guarantee_amount'];
                $letter_data['amount'] = @$data['amount'];
                $letter_data['ref_no'] = @$data['ref_no'];
                $letter_data['conditional_req'] = @$data['conditional_req'];
                $letter_data['reg_from_time'] = @$data['reg_from_time'];
                $letter_data['reg_to_time'] = @$data['reg_to_time'];
                $letter_data['deposit_due_at'] = @$data['deposit_due_at'];
                $letter_data['issued_at'] = @$data['issued_at'];
                $letter_data['enforcement'] = @$data['enforcement'];
                $letter_data['applied_at'] = @$data['applied_at'];
                $letter_data['current_academic_session'] = (!empty(@$data['student_program']->academicSession->name)) ? @$data['student_program']->academicSession->name : '';
                $letter_data['academic_session'] = (!empty($academic_session->name)) ? $academic_session->name : '';
                $letter_data['student_name'] = @$data['student']->name;
                $letter_data['student_email'] = @$data['student']->email;
                $letter_data['student_phone_mobile'] = @$data['student']->phone_mobile;
                $letter_data['study_mode'] = (!empty(@$data['student_program']->studyMode->name)) ? @$data['student_program']->studyMode->name : '';
                $letter_data['salutation'] = (!empty(@$data['student']->salutation->name)) ? @$data['student']->salutation->name : '';
                $letter_data['gender'] = @$data['student']->gender_name;
                $letter_data['id_no'] = @$data['student']->id_no;
                $letter_data['student_no'] = (!empty(@$data['student_program']->student_no)) ? @$data['student_program']->student_no : '';
                $letter_data['address'] = $address;
                $letter_data['staff_name'] = (!empty($staff->name)) ? $staff->name : '';
                $letter_data['staff_phone_office'] = '0123456789';//(!empty($staff->phone_office)) ? $staff->phone_office : ''; //TODO
                $letter_data['staff_phone_mobile'] = '0123456789';//(!empty($staff->phone_mobile)) ? $staff->phone_mobile : ''; //TODO
                $letter_data['staff_email'] = (!empty($staff->email)) ? $staff->email : '';
                $letter_data['faculty_code'] = (!empty($faculty->code)) ? $faculty->code : '';
                $letter_data['faculty_name'] = (!empty($faculty->name)) ? $faculty->name : '';
                $letter_data['program_type'] = 'Diploma';//$program_type->name; //TODO
                $letter_data['program'] = (!empty(@$data['student_program']->program->name)) ? @$data['student_program']->program->name : '';
                $letter_data['intake_no'] = (!empty(@$data['student_program']->intake->name)) ? @$data['student_program']->intake->name : '';
                $letter_data['program_code'] = (!empty(@$data['student_program']->program->code)) ? @$data['student_program']->program->code : '';
                $letter_data['nationality'] = @$data['student']->nationality->name;
                $letter_data['location'] = (!empty($location)) ? $location->name : '';
                $letter_data['recruited_by'] = (!empty(@$data['student']->marketingStaff->name)) ? @$data['student']->marketingStaff->name : 'N/A';
                $letter_data['admissions_status'] = (!empty($admissions_status->name)) ? $admissions_status->name : '';
                $letter_data['current_admissions_status'] = (!empty(@$data['student_program']->admissionStatus->name)) ? @$data['student_program']->admissionStatus->name : '';
                $letter_data['current_semester'] = @$data['student_program']->semester;
                $letter_data['next_semester'] = @$data['student_program']->semester + 1;
                $letter_data['outstanding_bill'] = 456.89; //TODO
                $letter_data['gpa'] = 3.40;//$student_semester->gpa; //TODO
                $letter_data['cgpa'] = 3.63;//$student_semester->cgpa; //TODO
                //Replacing the placeholder with value
                foreach ($matches[0] as $pholder) {
                    // Initialize
                    setlocale(LC_TIME, Session::get('app_locale'));

                    //STAFFNAME
                    if ($pholder == '{STAFFNAME}') {
                        $message_body = str_replace($pholder, $letter_data['staff_name'], $message_body);
                    }

                    //STAFFPHONEOFFICE
                    if ($pholder == '{STAFFPHONEOFFICE}') {
                        $message_body = str_replace($pholder, $letter_data['staff_phone_office'], $message_body);
                    }

                    //STAFFPHONEMOBILE
                    if ($pholder == '{STAFFPHONEMOBILE}') {
                        $message_body = str_replace($pholder, $letter_data['staff_phone_mobile'], $message_body);
                    }

                    //STAFFEMAIL
                    if ($pholder == '{STAFFEMAIL}') {
                        $message_body = str_replace($pholder, $letter_data['staff_email'], $message_body);
                    }

                    //CURRENTACADEMICSESSION
                    if ($pholder == '{CURRENTACADEMICSESSION}') {
                        $message_body = str_replace($pholder, $letter_data['current_academic_session'], $message_body);
                    }

                    //ACADEMICSESSION
                    if ($pholder == '{ACADEMICSESSION}') {
                        $message_body = str_replace($pholder, $letter_data['academic_session'], $message_body);
                    }

                    //STUDENTNAME
                    if ($pholder == '{STUDENTNAME}') {
                        $message_body = str_replace($pholder, $letter_data['student_name'], $message_body);
                    }

                    //STUDENTEMAIL
                    if ($pholder == '{STUDENTEMAIL}') {
                        $message_body = str_replace($pholder, $letter_data['student_email'], $message_body);
                    }

                    //STUDYMODE
                    if ($pholder == '{STUDYMODE}') {
                        $message_body = str_replace($pholder, $letter_data['study_mode'], $message_body);
                    }

                    //STUDENTNAME
                    if ($pholder == '{STUDENTPHONENUMBER}') {
                        $message_body = str_replace($pholder, $letter_data['student_phone_mobile'], $message_body);
                    }

                    //LOGO //TODO
                    // if ($pholder == '{LOGO}') {
                    //     $logo = '<table>
                    //         <tr>
                    //             <td><img src="' . Config::get('imagedir') . 'college_images/' . 'demo' . '/logo.png' . '"/></td>
                    //         </tr>
                    //     </table>';
                    //     $message_body = str_replace($pholder, $logo, $message_body);
                    // }

                    //COLLEGEADDRESS
                    if ($pholder == '{COLLEGEADDRESS}') {
                        $message_body = str_replace($pholder, $general_setting['address'], $message_body);
                    }

                    //COLLEGEWEBSITE
                    if ($pholder == '{COLLEGEWEBSITE}') {
                        $message_body = str_replace($pholder, $general_setting['website'], $message_body);
                    }

                    //COLLEGEFAX
                    if ($pholder == '{COLLEGEFAX}') {
                        $message_body = str_replace($pholder, $general_setting['fax_number'], $message_body);
                    }

                    //COLLEGENUMBER
                    if ($pholder == '{COLLEGENUMBER}') {
                        $message_body = str_replace($pholder, $general_setting['phone_number'], $message_body);
                    }

                    //COLLEGENAME
                    if ($pholder == '{COLLEGENAME}') {
                        $message_body = str_replace($pholder, $general_setting['institution_name'], $message_body);
                    }

                    //ICNUMBER/PASSPORT
                    if ($pholder == '{ICNUMBER/PASSPORT}') {
                        $message_body = str_replace($pholder, $letter_data['id_no'], $message_body);
                    }

                    //REMOVEHEADER
                    if ($pholder == '{REMOVEHEADER}') {
                        $css = '<style type="text/css">
                            @media print {
                                body {
                                    width:100%;
                                    padding-top:0% !important;
                                    font-family: Arial, serif;
                                }
                            }
                        </style>';
                        $message_body = str_replace($pholder, $css, $message_body);
                    }

                    //MATRIXNO
                    if ($pholder == '{STUDENTID}') {
                        $message_body = str_replace($pholder, $letter_data['student_no'], $message_body);
                    }

                    //PERMANENTADDRESS
                    if ($pholder == '{PERMANENTADDRESS}') {
                        $message_body = str_replace($pholder, $letter_data['address'], $message_body);
                    }

                    //COUNTRY
                    if ($pholder == '{COUNTRY}') {
                        $country = (!empty($student_address->country->name)) ? $student_address->country->name : '';
                        $message_body = str_replace($pholder, $country, $message_body);
                    }

                    //NATIONALITY
                    if ($pholder == '{NATIONALITY}') {
                        $message_body = str_replace($pholder, $letter_data['nationality'], $message_body);
                    }

                    //CONTACTADDRESS
                    if ($pholder == '{CONTACTADDRESS}') {
                        $contact_info = @$letter_data['contact']['name'];
                        $contact_info .= '<br/>';
                        $contact_info .= @$letter_data['contact']['address'];

                        $message_body = str_replace($pholder, $contact_info, $message_body);
                    }

                    //OUTSTANDING
                    if ($pholder == '{OUTSTANDING}') {
                        $message_body = str_replace($pholder, number_format($letter_data['outstanding_bill'], 2, '.', ','), $message_body);
                    }

                    //GUARANTEEAMOUNT
                    if ($pholder == '{GUARANTEEAMOUNT}') {
                        $message_body = str_replace($pholder, $letter_data['guarantee_amount'], $message_body);
                    }

                    //AMOUNT(RM)
                    if ($pholder == '{AMOUNT}') {
                        $message_body = str_replace($pholder, $letter_data['guarantee_amount'], $message_body);
                    }

                    //FIRSTSEMFEE
                    if ($pholder == '{FIRSTSEMFEE}') {
                        $message_body = str_replace($pholder, number_format($letter_data['fee'], 2, '.', ','), $message_body);
                    }

                    //DEPOSIT
                    if ($pholder == '{DEPOSIT}') {
                        $message_body = str_replace($pholder, number_format($letter_data['deposit'], 2, '.', ','), $message_body);
                    }

                    //FACULTYCODE
                    if ($pholder == '{FACULTYCODE}') {
                        $message_body = str_replace($pholder, $letter_data['faculty_code'], $message_body);
                    }

                    //FACULTYNAME
                    if ($pholder == '{FACULTYNAME}') {
                        $message_body = str_replace($pholder, $letter_data['faculty_name'], $message_body);
                    }

                    //PROGRAM
                    if ($pholder == '{PROGRAM}') {
                        $message_body = ucfirst(str_replace($pholder, $letter_data['program'], $message_body));
                    }

                    //PROGRAM CODE
                    if ($pholder == '{PROGRAMCODE}') {
                        $message_body = str_replace($pholder, $letter_data['program_code'], $message_body);
                    }

                    //PROGRAM CODE
                    if ($pholder == '{PROGRAMTYPE}') {
                        $message_body = str_replace($pholder, $letter_data['program_type'], $message_body);
                    }

                    //PROGRAMCAPS
                    if ($pholder == '{PROGRAMCAPS}') {
                        $message_body = str_replace($pholder, strtoupper($letter_data['program']), $message_body);
                    }

                    //VENUE
                    if ($pholder == '{VENUE}') {
                        $message_body = str_replace($pholder, $letter_data['location'], $message_body);
                    }

                    //CONDITIONALREQ
                    if ($pholder == '{CONDITIONALREQ}') {
                        $message_body = str_replace($pholder, $letter_data['conditionalreq'], $message_body);
                    }

                    //ENFORCEMENT
                    if ($pholder == '{ENFORCEMENT}') {
                        $message_body = str_replace($pholder, $letter_data['enforcement'], $message_body);
                    }

                    //REFNUMBER
                    if ($pholder == '{REFNUMBER}') {
                        $message_body = str_replace($pholder, $letter_data['ref_no'], $message_body);
                    }

                    //SALUTATION
                    if ($pholder == '{SALUTATION}') {
                        $message_body = str_replace($pholder, $letter_data['salutation'], $message_body);
                    }

                    //STUDENT STATUS
                    if (preg_match('/{\*(\w)\*STUDENTSTATUS}/', $pholder, $item)) {
                        $lang = $item[1];

                        $message_body = str_replace($pholder, $letter_data['admissions_status'], $message_body);
                    }

                    //DURATION
                    if (preg_match('/{\*(\w)\*DURATION}/', $pholder, $durationitem) || $pholder == '{DURATION}') {
                        if ($durationitem[1] == 'm') {
                            $frequency = FREQUENCY_MONTHLY;
                        } else {
                            $frequency = FREQUENCY_YEARLY;
                        }

                        $duration = (!empty(@$data['student_program']->program->program_duration)) ? Data::duration(@$data['student_program']->program->program_duration, $frequency) : '';

                        $message_body = str_replace($pholder, $duration, $message_body);
                    }

                    //INTAKE
                    if (preg_match('/{\*(\w)\*INTAKE}/', $pholder, $raw_intake)) {
                        $lang = $raw_intake[1];
                        $intakesession = explode('/', $letter_data['intake_no']);

                        $this->setDateTimeLocale($lang);

                        $intake = Carbon::createFromFormat('Y-m-d', strtotime('2017-' . $intakesession[1] . '-01'))->formatLocalized(DateUtil::date_to_strftime('F'));
                        $message_body = str_replace($pholder, $intake, $message_body);
                    }

                    //MAXDURATION //TODO
                    // if (preg_match('/{\*(\w)\*MAXDURATION}/', $pholder, $maxduration)) {
                    //     $lang = $maxduration[1];
                    //
                    //     //applied for 0330
                    //     $terminateendmonth_m = array(
                    //     'July' => 'Jun',
                    //     'January' => 'Disember'
                    //     );
                    //     $terminateendmonth_e = array(
                    //     'July' => 'June',
                    //     'January' => 'December'
                    //     );
                    //     $intakesession = explode('/', $letter_data['intake_no']);
                    //     $max = $intakesession[0] + 5;
                    //
                    //     switch ($lang) {
                    //         case 'm':
                    //         $maxdur = $terminateendmonth_m[date('F', mktime(0, 0, 0, $intakesession[1]))] . ' ' . $max;
                    //         break;
                    //         case 'e':
                    //         $maxdur = $terminateendmonth_e[date('F', mktime(0, 0, 0, $intakesession[1]))] . ' ' . $max;
                    //         // no break
                    //         default:
                    //         break;
                    //     }
                    //     $message_body = str_replace($pholder, $maxdur, $message_body);
                    // }

                    //CURRENT STATUS
                    if (preg_match('/{\*(\w)\*CURRENTSTATUS}/', $pholder)) {
                        $message_body = str_replace($pholder, $letter_data['current_admissions_status'], $message_body);
                    }

                    //CURRENT SEMESTER
                    if (preg_match('/{\*(\w)\*CURRENTSEMESTER}/', $pholder)) {
                        $message_body = str_replace($pholder, $letter_data['current_semester'], $message_body);
                    }

                    //CURRENT SEMESTER + 1
                    if (preg_match('/{\*(\w)\*NEXTSEMESTER}/', $pholder)) {
                        $message_body = str_replace($pholder, $letter_data['next_semester'], $message_body);
                    }

                    //CURRENTDATE
                    if (preg_match('/{\*(\w)\*CURRENTDATE\[([^}]*)\]}/', $pholder, $date)) {
                        $lang = $date[1];
                        $format = $date[2];

                        $this->setDateTimeLocale($lang);

                        $current_date = Carbon::now()->formatLocalized(DateUtil::date_to_strftime($format));

                        //Added <sup> tag to st, nd, rd or th
                        if (preg_match('/S/', $format)) {
                            $current_date = str_replace('st', '<sup>st</sup>', $current_date);
                            $current_date = str_replace('nd', '<sup>nd</sup>', $current_date);
                            $current_date = str_replace('rd', '<sup>rd</sup>', $current_date);
                            $current_date = str_replace('th', '<sup>th</sup>', $current_date);
                        }

                        $message_body = str_replace($pholder, $current_date, $message_body);
                    }

                    //REGDATESTART
                    if (preg_match('/{\*(\w)\*REGDATESTART\[([^}]*)\]}/', $pholder, $date)) {
                        $lang = $date[1];
                        $format = $date[2];

                        $this->setDateTimeLocale($lang);

                        $registered_from_at = Carbon::createFromTimestamp(strtotime($letter_data['registered_from_at']))->formatLocalized(DateUtil::date_to_strftime($format));
                        $message_body = str_replace($pholder, $registered_from_at, $message_body);
                    }

                    //REGDATEEND
                    if (preg_match('/{\*(\w)\*REGDATEEND\[([^}]*)\]}/', $pholder, $date)) {
                        $lang = $date[1];
                        $format = $date[2];
                        $this->setDateTimeLocale($lang);

                        $registered_to_at = Carbon::createFromTimestamp(strtotime($letter_data['registered_to_at']))->formatLocalized(DateUtil::date_to_strftime($format));
                        $message_body = str_replace($pholder, $registered_to_at, $message_body);
                    }

                    //REGTIMESTART
                    if (preg_match('/{REGTIMESTART\[([^}]*)\]}/', $pholder, $time)) {
                        $format = $time[1];

                        $reg_from_time = Carbon::createFromTimestamp(strtotime('2017-01-01 ' . $letter_data['reg_from_time']))->formatLocalized(DateUtil::date_to_strftime($format));
                        $message_body = str_replace($pholder, $reg_from_time, $message_body);
                    }

                    //REGTIMEEND
                    if (preg_match('/{REGTIMEEND\[([^}]*)\]}/', $pholder, $time)) {
                        $format = $time[1];

                        $reg_to_time = Carbon::createFromTimestamp(strtotime('2017-01-01 ' . $letter_data['reg_to_time']))->formatLocalized(DateUtil::date_to_strftime($format));
                        $message_body = str_replace($pholder, $reg_to_time, $message_body);
                    }

                    //DATEDUE
                    if (preg_match('/{\*(\w)\*DATEDUE\[([^}]*)\]}/', $pholder, $date)) {
                        $lang = $date[1];
                        $format = $date[2];
                        $this->setDateTimeLocale($lang);

                        $deposit_due_at = Carbon::createFromTimestamp(strtotime($letter_data['deposit_due_at']))->formatLocalized(DateUtil::date_to_strftime($format));
                        $message_body = str_replace($pholder, $deposit_due_at, $message_body);
                    }

                    //APPLICATIONDATE
                    if (preg_match('/{\*(\w)\*APPLICATIONDATE\[([^}]*)\]}/', $pholder, $date)) {
                        $lang = $date[1];
                        $format = $date[2];
                        $this->setDateTimeLocale($lang);

                        $applied_at = Carbon::createFromTimestamp(strtotime($letter_data['applied_at']))->formatLocalized(DateUtil::date_to_strftime($format));
                        $message_body = str_replace($pholder, $applied_at, $message_body);
                    }

                    //CURRENTDATEADD
                    if (preg_match('/{\*(\w)\*CURRENTDATEADD\[([^}]*)\]}/', $pholder, $date)) {
                        $lang = $date[1];
                        $format = $date[2];
                        $exploded = explode(' ', $format);
                        $this->setDateTimeLocale($lang);

                        $current_date = Carbon::now()->addDay($exploded[3])->formatLocalized(DateUtil::date_to_strftime($format));

                        //Added <sup> tag to st, nd, rd or th
                        if (preg_match('/S/', $format)) {
                            $current_date = str_replace('st', '<sup>st</sup>', $current_date);
                            $current_date = str_replace('nd', '<sup>nd</sup>', $current_date);
                            $current_date = str_replace('rd', '<sup>rd</sup>', $current_date);
                            $current_date = str_replace('th', '<sup>th</sup>', $current_date);
                        }

                        $message_body = str_replace($pholder, $applied_at, $message_body);
                    }

                    //VISA NUMBER
                    if ($pholder == '{VISANUMBER}') {
                        $visa_no = (!empty($visa->visa_no)) ? $visa->visa_no : '';
                        $message_body = str_replace($pholder, $visa_no, $message_body);
                    }

                    //VISA REFERENCE NUMBER
                    if ($pholder == '{VISAREFNUMBER}') {
                        $reference_no = (!empty($visa->reference_no)) ? $visa->reference_no : '';
                        $message_body = str_replace($pholder, $reference_no, $message_body);
                    }

                    //VISA EXPIRED DATE
                    if (preg_match('/{\*(\w)\*VISAEXPIREDDATE\[([^}]*)\]}/', $pholder, $visadate)) {
                        $lang = $visadate[1];
                        $format = $visadate[2];
                        $this->setDateTimeLocale($lang);

                        if (!empty($visa->visa_expired_at)) {
                            $visa_expired_at = Carbon::createFromTimestamp(strtotime($visa->visa_expired_at))->formatLocalized(DateUtil::date_to_strftime($format));

                            //Added <sup> tag to st, nd, rd or th
                            if (preg_match('/S/', $format)) {
                                $visa_expired_at = str_replace('st', '<sup>st</sup>', $visa_expired_at);
                                $visa_expired_at = str_replace('nd', '<sup>nd</sup>', $visa_expired_at);
                                $visa_expired_at = str_replace('rd', '<sup>rd</sup>', $visa_expired_at);
                                $visa_expired_at = str_replace('th', '<sup>th</sup>', $visa_expired_at);
                            }

                            $message_body = str_replace($pholder, $visa_expired_at, $message_body);
                        }
                    }

                    //ADDPAGEBREAKAFTER
                    if ($pholder == '{ADDPAGEBREAKAFTER}') {
                        $script = '<div class="page-break-after">&nbsp;</div>';
                        $message_body = str_replace($pholder, $script, $message_body);
                    }

                    //ADDPAGEBREAKBEFORE
                    if ($pholder == '{ADDPAGEBREAKBEFORE}') {
                        $script = '<div class="page-break-before">&nbsp;</div>';
                        $message_body = str_replace($pholder, $script, $message_body);
                    }

                    //DISABLEPAGEBREAKAFTER
                    if ($pholder == '{DISABLEPAGEBREAKAFTER}') {
                        $script = '<style type="text/css">
                            @media print {
                                div,printdiv{page-break-after: auto; margin-right:2px !important;
                                }
                                #footer, #topmenu, #top-panel, #pager, .noprint, #button1, #button2, .simplebutton, a-button
                                {
                                    display: none;
                                }
                            </style>';

                        $message_body = str_replace($pholder, $script, $message_body);
                    }

                    //NATIONALITY
                    if ($pholder == '{STUDENTNATIONALITY}') {
                        $message_body = str_replace($pholder, $letter_data['nationality'], $message_body);
                    }

                    //BARCODE //TODO
                    // if (preg_match('/{BARCODE\[/', $pholder)) {
                    //     $placeholder = $pholder;
                    //     $modifiedplaceholder = $pholder;
                    //     $beforelastchar = substr($placeholder, strlen($placeholder) - 2, 1);
                    //
                    //     if ($beforelastchar != ']') {
                    //         $placeholder = $pholder . ']}';
                    //         $subplaceholder = str_replace('{BARCODE[', '', $pholder);
                    //
                    //         preg_match_all('/{([^}]*)}/', $subplaceholder, $submatches);
                    //
                    //         $modifiedplaceholder = '{BARCODE[' . $this->map_place_holder($submatches[0][0]) . ']}';
                    //     }
                    //
                    //     if (preg_match('/{BARCODE\[([^}]*)\]}/', $modifiedplaceholder, $barcode)) {
                    //         $barcodeitem = $barcode[1];
                    //
                    //         $url = site_url('globalsys/print_urlsafe_barcode/' . encrypt_text($barcodeitem));
                    //         $item_barcode = '<img src="' . $url . '" alt="' . $barcodeitem . '" title="' . $barcodeitem . '"/>';
                    //
                    //         $message_body = str_replace($placeholder, $item_barcode, $message_body);
                    //     }
                    // }

                    //MARGIN
                    if (preg_match('/{MARGIN\[([^}]*)\]}/', $pholder, $margin)) {
                        $explodedmargin = explode(' ', $margin[1]);

                        $margin = '';
                        foreach ($explodedmargin as $marginlist) {
                            if ($marginlist == 'left' || $marginlist == 'right' || $marginlist == 'top' || $marginlist == 'bottom') {
                                $marginposition = $marginlist;
                            } else {
                                $marginvalue = $marginlist . "em";
                            }
                            if (!empty($marginposition)) {
                                $margin .= "margin-" . $marginposition . ":" . $marginvalue . " !important;";
                            }
                        }
                        $style = "<style>div {
                                $margin
                            }
                            table tr td{
                                $margin
                            }
                        </style>";

                        $message_body = str_replace($pholder, $style, $message_body);
                    }

                    //LETTERHEAD //TODO
                    // if ($pholder == '{LETTERHEADHEADER}') {
                    //     $letterhead = '<img src="' . $this->config->item('imagedir') . 'college_images/' . $collegecode . '/letterheadheader.jpg" width="700px" height="80px">';
                    //
                    //     $content = '
                    //     <style>
                    //         header {
                    //             margin-top:0px !important;
                    //             top: 0 !important;
                    //             position: fixed;
                    //             z-index: -1;
                    //         }
                    //     </style>
                    //     <header>
                    //         <div class="letterhead" align="center">'. $letterhead.'</div>
                    //     </header>';
                    //     $message_body = str_replace($pholder, $content, $message_body);
                    // }

                    //LETTERHEADFOOTER //TODO
                    // if ($pholder == '{LETTERHEADFOOTER}') {
                    //     $footer1 = '<img src="' . $this->config->item('imagedir') . 'college_images/' . $collegecode . '/letterheadfooter1.jpg" width="120px" height="80px">';
                    //     $footer2 = '<img src="' . $this->config->item('imagedir') . 'college_images/' . $collegecode . '/letterheadfooter2.jpg" width="100%" height="10px">';
                    //
                    //     $content = '
                    //     <style>
                    //         footer {
                    //             bottom: 0 !important;
                    //             position: fixed;
                    //             z-index: -1;
                    //         }
                    //     </style>
                    //     <footer>
                    //         <div class="footer1" align="center">'. $footer1.'<br/></div>
                    //         <div class="footer1" align="center">'. $footer2.'</div>
                    //     </footer>';
                    //     $message_body = str_replace($pholder, $content, $message_body);
                    // }

                    //DATEISSUE
                    if (preg_match('/{\*(\w)\*DATEISSUE\[([^}]*)\]}/', $pholder, $date)) {
                        $lang = $date[1];
                        $format = $date[2];
                        $this->setDateTimeLocale($lang);

                        $issued_at = Carbon::createFromTimestamp(strtotime($letter_data['issued_at']))->formatLocalized(DateUtil::date_to_strftime($format));
                        $message_body = str_replace($pholder, $issued_at, $message_body);
                    }

                    //RECRUITEDBY
                    if ($pholder == '{RECRUITEDBY}') {
                        $message_body = str_replace($pholder, $letter_data['recruited_by'], $message_body);
                    }

                    //GPA
                    if ($pholder == '{GPA}') {
                        $message_body = str_replace($pholder, number_format($letter_data['gpa'], 2, '.', ','), $message_body);
                    }

                    //GPA
                    if ($pholder == '{CGPA}') {
                        $message_body = str_replace($pholder, number_format($letter_data['cgpa'], 2, '.', ','), $message_body);
                    }
                }

                return $message_body;
            }else{
                return $template_body;
            }
        }
    }
}
