@php
 
 $reportList = [
    "summary" => [
        "adjust-times",
        "adjustment-audit",
        "adjustment-audit-by-user",
        "monthly-summary",
        "weekly-summary"
    ],
    "attendance" => [
        "time-attendance-audit-trail",
        "time-attendance-daily-hours-worked",
        "time-attendance-daily-shifts",
        "time-attendance-hours-worked"
    ],
    "custom-reports" => [
        "weekly-line-sales",
        "shelf-edge-labels",
        "stock-labels"

    ],
    "stock-control" => [
        "shelf-edge-labels",
        "stock-labels"
    ],
    "centralised-customer" => [
        "blacklisted-customer",
        "customer-account-last-used",
        "customer-balance",
        "customer-balance-audit",
        "customer-credit-debit",
        "customer-email-list",
        "customer-expiry",
        "customer-expiry-no-date-filter",
        "customer-list",
        "customer-plu-sales",
        "customer-points",
        "customer-snapshot",
        "customer-spend-by-group",
        "customer-spend-by-group-with-vat",
        "customer-spend-by-week",
        "customer-statement",
        "customer-transaction-history",
        "customer-transaction-summary",
        "free-school-meal-usage-daily",
        "free-school-meal-usage-with-detail",
        "manual-balance-adjustments",
        "top-customer-sales",
        "top-n-customer-spend-by-value",
        "total-customer-discount",
        "clerk-detail-link-report",
        "clerk-list",
        "plu-sales-by-clerk",
        "clerk-pay-rate-summary",
        "time-and-attendance-audit-trail",
    ],
    "customers" => [
        "customer-balance",
        "customer-expiry",
        "customer-list",
        "customer-plu-sales",
        "customer-spend-by-group",
        "customer-spend-by-group-with-vat",
        "customer-spend-by-week",
        "customer-statement",
        "customer-transaction-history",
        "customer-transaction-history-with-detail",
        "customer-transaction-summary",
        "free-school-meal-usage-daily",
        "free-school-meal-usage-with-detail",
        "top-customer-sales",
        "top-n-customer-spend-by-value",
        "total-customer-discount"
    ],

    "department" => [
        "department-sales-bar-graph",
        "department-sales-per-till",
        "department-sales-pie-chart",
        "department-totals-by-day-week"
    ],

   
    "exports" => [
        "customer-export",
        "finance-export-dept",
        "finance-export-dept-nodecimal",
        "finance-export-fixedtotal",
        "finance-export-plugroup",
        "finance-export-plugroup-nodecimal",
        "finance-export-purchasedept",
        "finance-export-purchasedept-nodecimal",
        "plu-active-stock-links-export",
        "plu-detail-export",
        "plu-export-plusales",
        "plu-stock-detail-export",
    ],

    "financial" => [
        "avg-dept-sales-by-day",
        "avg-dept-sales-by-day-and-hour",
        "avg-sales-by-day",
        "avg-sales-by-day-and-hour",
        "batch-report",
        "department-sales",
        "dept-comparison",
        "eat-in-takeout",
        "finalise-sales",
        "fixed-totals-by-day",
        "fixed-total-comparison",
        "fixed-total-sales",
        "fixed-total-sales-by-site",
        "fixed-total-sales-by-till",
        "group-comparison",
        "hourly-sales",
        "mix-and-match-sales",
        "plu-group-sales",
        "plu-group-sales-by-till",
        "seven-day-cash-report",
        "site-comparison",
        "tax-sales",
        "tax-sales-by-site",
        "tax-sales-by-till",
        "transaction-key-sales",
        "transaction-key-sales-by-clerk",
        "transaction-key-sales-per-till",
        "transaction-key-sales-per-till-by-clerk",
    ],
   
    "plu" => [
        "house-bon-report",
        "plu-id-links",
        "plu-allergen-list",
        "plu-allocated-to-keyboard",
        "plu-ceased-selling",
        "plu-details",
        "plu-gross-profit-performance",
        "plu-last-time-sold",
        "plu-linked-to-mix-&amp;-match-discounts",
        "plu-list-by-tax",
        "plu-price-@-sales",
        "plu-price-level-sales",
        "plu-price-list",
        "plu-price-list-by-dept",
        "plu-price-list-by-group",
        "plu-sales",
        "plu-sales-by-dept",
        "plu-sales-by-group",
        "plu-sales-by-name",
        "plu-sales-by-remote-terminal-with-profit",
        "plu-sales-with-dept-and-group",
        "plu-sales-with-discounts-by-dept",
        "plu-tags",
        "plu-tax-sales",
        "plu-top-sellers-by-profit",
        "plu-top-sellers-by-quantity",
        "plu-top-sellers-by-value"

    ],
   
    "refund-mode-transactions" => [
        "refund-mode-plu-sales",
        "refund-mode-plu-sales-by-clerk",
        "refund-mode-plu-sales-by-dept",
        "refund-mode-plu-sales-by-group",
        "refund-mode-transaction-summary",
        "refund-mode-transaction-summary-with-detail",
    ],

    "stock-control" => [
        "movement-sales-by-dept",
        "plu-active-stock-links",
        "plu-by-supplier",
        "plu-current-stock"
    ],

    "other" => [
        "error-corrected-plu",
        "reason-total",
    ],

];


@endphp    


    <label class="uk-form-label" for="form-stacked-text">REPORT </label> <br>
    <select class="uk-select uk-width-expand" name="report">
        <option selected disabled>Please Select Report</option>
        @foreach ($reportList as $reportListKey => $reportListItem)
            <optgroup label="{{ Str::upper( Str::of($reportListKey)->replace('_', ' ') ) }}">
                @foreach ($reportListItem as $report)
                    <option value="{{$reportListKey}}.{{$report}}">
                        {{ Str::ucfirst( $report ) }}    
                    </option>
                @endforeach
            </optgroup>
        @endforeach
    </select>
