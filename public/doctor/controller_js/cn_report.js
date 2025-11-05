
$(function (){

        var table = $('#cims_data_table');
        
        if ($.fn.DataTable.isDataTable('#cims_data_table')) {
            table.DataTable().destroy(); 
        }


        
        table = $('#cims_data_table').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            ajax: base_url + "/doctor/report/data-table",          
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'test_result_code',
                    name: 'test_result_code'
                },

                {
                    data: 'pet_code',
                    name: 'pet_code'
                },

                {
                    data: 'pet_name',
                    name: 'pet_name'
                },

                {
                    data: 'pet_parent',
                    name: 'pet_parent'
                },

                {
                    data: 'pet_parent_mobile',
                    name: 'pet_parent_mobile'
                },

                {
                    data: 'tests',
                    name: 'tests'
                },

                {
                    data: 'appointment_datetime',
                    name: 'appointment_datetime'
                },

                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false
                },


                // {
                //     data: 'done',
                //     name: 'done'
                // },

                // {
                //     data: 'signed',
                //     name: 'signed'
                // },

                // {
                //   data: 'assigned_doctor',
                //   name: 'assigned_doctor'
                // },

                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        function reload_table() {
            table.DataTable().ajax.reload(null, false);
        }

    });






