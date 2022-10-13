@php
   $reportList = [
       "summary" => [
           "adjust_times",
           "adjustment_audit",
           "adjustment_audit_by_user",
           "monthly_summary",
           "weekly_summary"
       ],
       "attendance" => [
           "time_attendance_audit_trail",
           "time_attendance_daily_hours_worked",
           "time_attendance_daily_shifts",
           "time_attendance_hours_worked"
       ],
       "custom_reports" => [
           "weekly_line_sales",
           "Shelf Edge Labels",
           "Stock Labels"
 
       ],
       "stock_control" => [
           "shelf_edge_labels",
           "stock_labels"
       ],
       "centralised_customers" => [
           "blacklisted_customer",
           "customer_account_last_used",
           "customer_balance",
           "customer_balance_audit",
           "customer_credit_debit",
           "customer_email_list",
           "customer_expiry",
           "customer_expiry_no_date_filter",
           "customer_list",
           "customer_plu_sales",
           "customer_points",
           "customer_snapshot",
           "customer_spend_by_group",
           "customer_spend_by_group_with_vat",
           "customer_spend_by_week",
           "customer_statement",
           "customer_transaction_history",
           "customer_transaction_summary",
           "free_school_meal_usage_daily",
           "free_school_meal_usage_with_detail",
           "manual_balance_adjustments",
           "top_customer_sales",
           "top_n_customer_spend_by_value",
           "total_customer_discount",
           "clerk_detail_link_report",
           "clerk_list",
           "plu_sales_by_clerk",
           "clerk_pay_rate_summary",
           "time_and_attendance_audit_trail",
       ],
       "customers" => [
           "customer_balance",
           "customer_expiry",
           "customer_list",
           "customer_plu_sales",
           "customer_spend_by_group",
           "customer_spend_by_group_with_vat",
           "customer_spend_by_week",
           "customer_statement",
           "customer_transaction_history",
           "customer_transaction_history_with_detail",
           "customer_transaction_summary",
           "free_school_meal_usage_daily",
           "free_school_meal_usage_with_detail",
           "top_customer_sales",
           "top_n_customer_spend_by_value",
           "total_customer_discount"
       ],
 
       "department" => [
           "department_sales_bar_graph",
           "department_sales_per_till",
           "department_sales_pie_chart",
           "department_totals_by_day_week"
       ],
 
      
       "exports" => [
           "customer_export",
           "finance_export_dept",
           "finance_export_dept_nodecimal",
           "finance_export_fixedtotal",
           "finance_export_plugroup",
           "finance_export_plugroup_nodecimal",
           "finance_export_purchasedept",
           "finance_export_purchasedept_nodecimal",
           "plu_active_stock_links_export",
           "plu_detail_export",
           "plu_export_plusales",
           "plu_stock_detail_export",
       ],
 
       "financial" => [
           "avg_dept_sales_by_day",
           "avg_dept_sales_by_day_and_hour",
           "avg_sales_by_day",
           "avg_sales_by_day_and_hour",
           "batch_report",
           "department_sales",
           "dept_comparison",
           "eat_in_takeout",
           "finalise_sales",
           "fixed_totals_by_day",
           "fixed_total_comparison",
           "fixed_total_sales",
           "fixed_total_sales_by_site",
           "fixed_total_sales_by_till",
           "group_comparison",
           "hourly_sales",
           "mix_and_match_sales",
           "plu_group_sales",
           "plu_group_sales_by_till",
           "seven_day_cash_report",
           "site_comparison",
           "tax_sales",
           "tax_sales_by_site",
           "tax_sales_by_till",
           "transaction_key_sales",
           "transaction_key_sales_by_clerk",
           "transaction_key_sales_per_till",
           "transaction_key_sales_per_till_by_clerk",
       ],
      
       "plu" => [
           "house_bon_report",
           "plu_id_links",
           "plu_allergen_list",
           "plu_allocated_to_keyboard",
           "plu_ceased_selling",
           "plu_details",
           "plu_gross_profit_performance",
           "plu_last_time_sold",
           "plu_linked_to_mix_&amp;_match_discounts",
           "plu_list_by_tax",
           "plu_price_@_sales",
           "plu_price_level_sales",
           "plu_price_list",
           "plu_price_list_by_dept",
           "plu_price_list_by_group",
           "plu_sales",
           "plu_sales_by_dept",
           "plu_sales_by_group",
           "plu_sales_by_name",
           "plu_sales_by_remote_terminal_with_profit",
           "plu_sales_with_dept_and_group",
           "plu_sales_with_discounts_by_dept",
           "plu_tags",
           "plu_tax_sales",
           "plu_top_sellers_by_profit",
           "plu_top_sellers_by_quantity",
           "plu_top_sellers_by_value"
 
       ],
      
       "refund_mode_transactions" => [
           "refund_mode_plu_sales",
           "refund_mode_plu_sales_by_clerk",
           "refund_mode_plu_sales_by_dept",
           "refund_mode_plu_sales_by_group",
           "refund_mode_transaction_summary",
           "refund_mode_transaction_summary_with_detail",
       ],
 
       "stock_control" => [
           "movement_sales_by_dept",
           "plu_active_stock_links",
           "plu_by_supplier",
           "plu_current_stock"
       ],
 
       "other" => [
           "error_corrected_plu",
           "reason_total",
       ],
 
   ];
 

@endphp    


    <label class="uk-form-label" for="form-stacked-text">REPORT </label> <br>
    <select class="uk-select uk-width-expand" name="title">
        <option selected disabled>Please Select Report</option>
        @foreach ($reportList as $reportListKey => $reportListItem)
            <optgroup label="{{ Str::upper( Str::of($reportListKey)->replace('_', ' ') ) }}">
                @foreach ($reportListItem as $report)
                    <option value="report[{{$reportListKey}}][{{$report}}][]" data-select2-id="16">
                        {{ Str::ucfirst( Str::of($report)->replace('_', ' ') ) }}    
                    </option>
                @endforeach
            </optgroup>
        @endforeach
    </select>
