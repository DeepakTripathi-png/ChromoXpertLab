<div class="card-body">
    @php use App\Helpers\Helpers\Helper; @endphp
    <div class="table-responsive">
    <table id="report_record" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width="5%">Sr No.</th>
                    <th width="5%">Date</th>
                    <th width="10%">Employee ID</th>
                    <th width="20%">Employee Name</th>
                    <th width="30%">Department and Designation</th>
                    <th width="10%" style="margin: auto;">Attendance Status</th>
                    <th width="20%">Remark</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($attendances) && $attendances->count() > 0)
                    @php $i=1; @endphp
                    @foreach($attendances as $attendance)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ !empty($attendance->date) ? App\Helpers\Helpers\Helper::getCreatedAtDate($attendance->date) : '' }}</td>
                            <td>{{ !empty($attendance->employee->code) ? $attendance->employee->code : '' }}</td>
                            <td>{{ !empty($attendance->employee->name) ? $attendance->employee->name : '' }}</td>
                            <td>{{ !empty($attendance->employee->department_id) ? App\Helpers\Helpers\Helper::getDepartmentById($attendance->employee->department_id) : '' }}  {{ !empty($attendance->employee->designation_id) ? App\Helpers\Helpers\Helper::getDesignationById($attendance->employee->designation_id) : '' }}</td>
                            <td>{{ !empty($attendance->attendance_status) ? $attendance->attendance_status : '' }}</td>
                            <td>{{ !empty($attendance->remark) ? $attendance->remark : '' }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr><td colspan="97">!! No Record Found !!</td></tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
   