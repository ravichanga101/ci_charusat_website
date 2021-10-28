<script src="https://code.jquery.com/jquery-2.2.4.min.js"
    integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.min.js"
    integrity="sha512-Bkf3qaV86NxX+7MyZnLPWNt0ZI7/OloMlRo8z8KPIEUXssbVwB1E0bWVeCvYHjnSPwh4uuqDryUnRdcUw6FoTg=="
    crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/js/jquery.tablesorter.min.js"
    integrity="sha512-qzgd5cYSZcosqpzpn7zF2ZId8f/8CHmFKZ8j7mU4OUXTNRd5g+ZHBPsgKEwoqxCtdQvExE5LprwwPAgoicguNg=="
    crossorigin="anonymous"></script>

<div id="navbar"><span>Red Stapler - SheetJS </span></div>
<div id="wrapper">

    <input type="file" id="input-excel" />
    <button onclick="add_sorting();">doit</button>
</div>
<script>
/* set up async GET request */
var req = new XMLHttpRequest();
req.open("GET", url, true);
req.responseType = "arraybuffer";

req.onload = function(e) {
    var data = new Uint8Array(req.response);
    var workbook = XLSX.read(data, {
        type: "array"
    });

    /* DO SOMETHING WITH workbook HERE */
    var htmlstr = XLSX.write(workbook, {

        type: 'binary',
        bookType: 'html'
    });
    $('#wrapper')[0].innerHTML += htmlstr;
}

req.send();
</script>

<script>
$('#input-excel').change(function(e) {
    var reader = new FileReader();
    reader.readAsArrayBuffer(e.target.files[0]);
    reader.onload = function(e) {
        var data = new Uint8Array(reader.result);
        var wb = XLSX.read(data, {
            type: 'array'
        });
        var htmlstr = XLSX.write(wb, {

            type: 'binary',
            bookType: 'html'
        });
        $('#wrapper')[0].innerHTML += htmlstr;
    }
});


function add_sorting() {
    alert();
    // call the tablesorter plugin
    $("table").tablesorter({
        theme: 'blue',

        // hidden filter input/selects will resize the columns, so try to minimize the change
        widthFixed: true,

        // initialize zebra striping and filter widgets
        widgets: ["zebra", "filter"],

        // headers: { 5: { sorter: false, filter: false } },

        widgetOptions: {

            // extra css class applied to the table row containing the filters & the inputs within that row
            filter_cssFilter: '',

            // If there are child rows in the table (rows with class name from "cssChildRow" option)
            // and this option is true and a match is found anywhere in the child row, then it will make that row
            // visible; default is false
            filter_childRows: false,

            // if true, filters are collapsed initially, but can be revealed by hovering over the grey bar immediately
            // below the header row. Additionally, tabbing through the document will open the filter row when an input gets focus
            filter_hideFilters: false,

            // Set this option to false to make the searches case sensitive
            filter_ignoreCase: true,

            // jQuery selector string of an element used to reset the filters
            filter_reset: '.reset',

            // Use the $.tablesorter.storage utility to save the most recent filters
            filter_saveFilters: true,

            // Delay in milliseconds before the filter widget starts searching; This option prevents searching for
            // every character while typing and should make searching large tables faster.
            filter_searchDelay: 300,

            // Set this option to true to use the filter to find text from the start of the column
            // So typing in "a" will find "albert" but not "frank", both have a's; default is false
            filter_startsWith: false,

            // Add select box to 4th column (zero-based index)
            // each option has an associated function that returns a boolean
            // function variables:
            // e = exact text from cell
            // n = normalized value returned by the column parser
            // f = search filter input value
            // i = column index
            filter_functions: {

                // Add select menu to this column
                // set the column value to true, and/or add "filter-select" class name to header
                // '.first-name' : true,

                // Exact match only
                1: function(e, n, f, i, $r, c, data) {
                    return e === f;
                },

                // Add these options to the select dropdown (regex example)
                2: {
                    "A - D": function(e, n, f, i, $r, c, data) {
                        return /^[A-D]/.test(e);
                    },
                    "E - H": function(e, n, f, i, $r, c, data) {
                        return /^[E-H]/.test(e);
                    },
                    "I - L": function(e, n, f, i, $r, c, data) {
                        return /^[I-L]/.test(e);
                    },
                    "M - P": function(e, n, f, i, $r, c, data) {
                        return /^[M-P]/.test(e);
                    },
                    "Q - T": function(e, n, f, i, $r, c, data) {
                        return /^[Q-T]/.test(e);
                    },
                    "U - X": function(e, n, f, i, $r, c, data) {
                        return /^[U-X]/.test(e);
                    },
                    "Y - Z": function(e, n, f, i, $r, c, data) {
                        return /^[Y-Z]/.test(e);
                    }
                },

                // Add these options to the select dropdown (numerical comparison example)
                // Note that only the normalized (n) value will contain numerical data
                // If you use the exact text, you'll need to parse it (parseFloat or parseInt)
                4: {
                    "< $10": function(e, n, f, i, $r, c, data) {
                        return n < 10;
                    },
                    "$10 - $100": function(e, n, f, i, $r, c, data) {
                        return n >= 10 && n <= 100;
                    },
                    "> $100": function(e, n, f, i, $r, c, data) {
                        return n > 100;
                    }
                }
            }

        }

    });

}
</script>