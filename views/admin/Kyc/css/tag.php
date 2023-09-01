<!-- data table -->
<link rel="stylesheet" href="<?= URL ?>public/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.css">

<style>
/* CSS to fix the position of the action column */
.dataTables_scrollHeadInner table {
    width: 100% !important;
    table-layout: fixed;
}

.dataTables_scrollHeadInner th:last-child,
.dataTables_scrollBody td:last-child {
    position: sticky !important;
    right: 0;
    z-index: 1;
}

@media (max-width: 767px) {

    .dataTables_scrollHeadInner th:last-child,
    .dataTables_scrollBody td:last-child {
        position: static !important;
        z-index: 2;
    }

    .table-th,
    .table-td {
        left: auto !important;
        z-index: auto !important;
    }
}

</style>
