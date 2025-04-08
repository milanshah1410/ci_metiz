<?php

namespace App\Controllers;

use App\Models\EmployeeModel;
use App\Models\LeaveTypeModel;
use App\Models\LeaveBalanceModel;
use App\Models\EmployeeLeaveModel;
use App\Models\NonWorkingDayModel;
use App\Models\CountryModel;
use App\Models\StateModel;
use App\Models\CityModel;

class LeaveController extends BaseController
{
    protected $employeeModel;
    protected $leaveTypeModel;
    protected $leaveBalanceModel;
    protected $employeeLeaveModel;
    protected $nonWorkingDayModel;
    protected $countryModel;
    protected $stateModel;
    protected $cityModel;
    
    public function __construct()
    {
        $this->employeeModel = new EmployeeModel();
        $this->leaveTypeModel = new LeaveTypeModel();
        $this->leaveBalanceModel = new LeaveBalanceModel();
        $this->employeeLeaveModel = new EmployeeLeaveModel();
        $this->nonWorkingDayModel = new NonWorkingDayModel();
        $this->countryModel = new CountryModel();
        $this->stateModel = new StateModel();
        $this->cityModel = new CityModel();
    }
    
    public function index()
    {
        // Get logged in employee details
        $employeeCode = session()->get('employee_code');
        $employee = $this->employeeModel->where('employee_code', $employeeCode)->first();
        if (!$employee) {
            return redirect()->to('/login')->with('error', 'Please login to continue');
        }
        
        // Get employee leave records
        $leaveRecords = $this->employeeLeaveModel->getEmployeeLeaves($employeeCode);
        
        // Get leave balance summary for graphs
        $leaveBalanceSummary = $this->leaveBalanceModel->getBalanceSummary($employeeCode);
        
        return view('leave/list', [
            'employee' => $employee,
            'leaveRecords' => $leaveRecords,
            'leaveBalance' => $leaveBalanceSummary
        ]);
    }
    
    public function applyLeave()
    {
        // Get logged in employee details
        $employeeCode = session()->get('employee_code');
        $employee = $this->employeeModel->where('employee_code', $employeeCode)->first();
        
        if (!$employee) {
            return redirect()->to('/login')->with('error', 'Please login to continue');
        }
        // Get employee leave balance
        $leaveTypes = $this->leaveTypeModel->getLeaveTypesWithBalance($employeeCode);
        
        // Get countries
        $countries = $this->countryModel->findAll();
        
        return view('leave/form', [
            'employee' => $employee,
            'leaveTypes' => $leaveTypes,
            'countries' => $countries
        ]);
    }
    
    public function submitLeave()
    {
        // Validate form data
        $rules = [
            'employee_code' => 'required',
            'leave_type' => 'required|numeric',
            'from_date' => 'required|valid_date',
            'to_date' => 'required|valid_date',
            'comments' => 'required|min_length[3]|max_length[300]',
            'country' => 'required|numeric',
            'state' => 'required|numeric',
            'city' => 'required|numeric',
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }
        
        // Get form data
        $employeeCode = $this->request->getPost('employee_code');
        $leaveTypeId = $this->request->getPost('leave_type');
        $fromDate = $this->request->getPost('from_date');
        $toDate = $this->request->getPost('to_date');
        $comments = $this->request->getPost('comments');
        $country = $this->request->getPost('country');
        $state = $this->request->getPost('state');
        $city = $this->request->getPost('city');
        
        // Check if to_date is greater than from_date
        if (strtotime($toDate) < strtotime($fromDate)) {
            return redirect()->back()->withInput()->with('error', 'To date must be greater than or equal to from date');
        }
        // Check for leave overlap
        $overlap = $this->checkLeaveOverlap($employeeCode, $fromDate, $toDate);
        if ($overlap['overlap']) {
            return redirect()->back()->withInput()->with('error', 'You already have a leave application for these dates: ' . $overlap['message']);
        }

        // Calculate working days
        $workingDaysResult = $this->calculateWorkingDays($fromDate, $toDate);
        $workingDays = $workingDaysResult['working_days'];
        $skipDates = $workingDaysResult['skip_dates'];
        
        // Check if leave balance is sufficient
        $leaveBalance = $this->leaveBalanceModel->getCurrentBalance($employeeCode, $leaveTypeId);
        if ($workingDays > $leaveBalance) {
            return redirect()->back()->withInput()->with('error', 'Insufficient leave balance. You have only ' . $leaveBalance . ' days available.');
        }
        // Begin transaction
        $db = \Config\Database::connect();
        $db->transBegin();
        
        try {
            // Insert leave record
            $leaveData = [
                'employee_code' => $employeeCode,
                'leavetype' => $leaveTypeId,
                'fromdate' => $fromDate,
                'todate' => $toDate,
                'numberofDays' => $workingDays,
                'comment' => $comments
            ];
            $this->employeeLeaveModel->insert($leaveData);
            // Update leave balance
            $newBalance = $leaveBalance - $workingDays;
            $this->leaveBalanceModel->updateLatestBalance($employeeCode, $leaveTypeId, $newBalance);
            
            // Commit transaction
            $db->transCommit();
            
            return redirect()->to('/leave')->with('success', 'Leave application submitted successfully. ' . $workingDays . ' days deducted from your balance.');
        } catch (\Exception $e) {
            // Rollback transaction
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Error processing your request: ' . $e->getMessage());
        }
    }
    
    public function getStates($countryId)
    {        
        $states = $this->stateModel->where('country_id', $countryId)->findAll();
        
        return $this->response->setJSON($states);
    }
    
    public function getCities($stateId)
    {        
        $cities = $this->cityModel->where('state_id', $stateId)->findAll();
        
        return $this->response->setJSON($cities);
    }
    
    private function checkLeaveOverlap($employeeCode, $fromDate, $toDate)
    {
        $existingLeaves = $this->employeeLeaveModel
            ->where('employee_code', $employeeCode)
            ->where('((fromdate BETWEEN "' . $fromDate . '" AND "' . $toDate . '") OR 
                    (todate BETWEEN "' . $fromDate . '" AND "' . $toDate . '") OR 
                    ("' . $fromDate . '" BETWEEN fromdate AND todate) OR 
                    ("' . $toDate . '" BETWEEN fromdate AND todate))')
            ->findAll();
        
        if (count($existingLeaves) > 0) {
            $overlappingDates = [];
            
            foreach ($existingLeaves as $leave) {
                $overlappingDates[] = date('Y-m-d', strtotime($leave['fromdate'])) . ' to ' . date('Y-m-d', strtotime($leave['todate']));
            }
            
            return [
                'overlap' => true,
                'message' => implode(', ', $overlappingDates)
            ];
        }
        
        return ['overlap' => false];
    }
    
    private function calculateWorkingDays($fromDate, $toDate)
    {
        $workingDays = 0;
        $skipDates = [];
        $currentDate = strtotime($fromDate);
        $endDate = strtotime($toDate);
        
        while ($currentDate <= $endDate) {
            $currentDateString = date('Y-m-d', $currentDate);
            
            // Check if it's a weekend (Saturday = 6, Sunday = 0)
            $dayOfWeek = date('w', $currentDate);
            $isWeekend = ($dayOfWeek == 0 || $dayOfWeek == 6);
            
            // Check if it's a non-working day
            $isNonWorkingDay = $this->nonWorkingDayModel
                ->where('date', $currentDateString)
                ->countAllResults() > 0;
            
            if (!$isWeekend && !$isNonWorkingDay) {
                $workingDays++;
            } else {
                $skipDates[] = $currentDateString;
            }
            
            // Move to next day
            $currentDate = strtotime('+1 day', $currentDate);
        }
        
        return [
            'working_days' => $workingDays,
            'skip_dates' => $skipDates
        ];
    }
}