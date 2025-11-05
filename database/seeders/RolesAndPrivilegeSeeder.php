<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class RolesAndPrivilegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rolesPrivileges = [
            [
                'role_name' => "Super Admin",
                'privileges' => 'dashboard_view, master_view, site_view, site_add, site_edit, site_delete, site_status, department_view, department_add, department_edit, department_delete, department_status, designation_view, designation_add, designation_edit, designation_delete, designation_status, category_view, category_add, category_edit, category_delete, category_status, sub_categories_view, sub_categories_add, sub_categories_edit, sub_categories_delete, sub_categories_status, unit_view, unit_add, unit_edit, unit_delete, unit_status, item_view, item_add, item_edit, item_delete, item_status, document_category_view, document_category_add, document_category_edit, document_category_delete, document_category_status, document_sub_categories_view, document_sub_categories_add, document_sub_categories_edit, document_sub_categories_delete, document_sub_categories_status, warehouse_view, warehouse_add, warehouse_edit, warehouse_delete, warehouse_status, configuration_view, configuration_add, configuration_edit, configuration_delete, configuration_status, employee_view, employee_add, employee_edit, employee_delete, employee_status, employee_other, vendor_view, vendor_add, vendor_edit, vendor_delete, vendor_status, main_inventory_view, main_inventory_add, main_inventory_edit, main_inventory_delete, main_inventory_status, main_inventory_other, site_inventory_view, site_inventory_other, item_requisition_view, item_requisition_add, item_requisition_edit, item_requisition_delete, utilized_item_view, utilized_item_add, utilized_item_edit, utilized_item_delete, utilized_item_status, utilized_item_other, all_document_view, all_document_add, all_document_edit, all_document_delete, support_ticket_view, support_ticket_add, support_ticket_edit, dpr_view, dpr_add, dpr_edit, dpr_delete, dpr_status, dpr_other, attendance_view, attendance_add, attendance_edit, attendance_delete, attendance_status, attendance_other, training_view, training_add, training_edit, training_delete, training_status, training_other, report_view, report_add, report_edit, report_delete, report_status, report_other, system_users_view, user_view, user_add, user_edit, user_delete, user_status_change, role_privileges_view, role_privileges_add, role_privileges_edit, role_privileges_delete, role_privileges_status_change, settings_view, general_setting_view, general_setting_add, general_setting_edit, visual_setting_view, visual_setting_add, visual_setting_edit'
            ],
        ];

        foreach ($rolesPrivileges as $data) {
            DB::table('role_privileges')->insert($data);
        }
    }
}
