<!DOCTYPE html>
<html>
<head>
    <title>POS</title>
    <style>
      table {
        border-collapse: collapse;
        width: 100%;
      }
      
      th, td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
      }
      
      th {
        background-color: #f2f2f2;
      }
      
      tbody tr:nth-child(even) {
        background-color: #f9f9f9;
      }
      
      tbody tr:hover {
        background-color: #e6e6e6;
      }
    </style>
</head>
<body>
    <table style="border: 0px; margin-bottom: 10px;">
        <thead>
            <th style="font-size: 20px; border: 0px; background-color: transparent;">Sales & Expenses Summary Report</th>
            <th style="font-size: 18px; text-align: right; border: 0px; background-color: transparent;">{{ date('F d, Y') }}</th>
        </thead>
    </table>

    <table>
        <thead>
            <tr style="font-size: 15px;">
                <th style="font-size: 15px;">Date</th>
                <th style="font-size: 15px;">Sales</th>
                <th style="font-size: 15px;">Expenses</th>
                <th style="font-size: 15px;">Profit</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $val)
                <tr style="font-size: 12px;">
                    <td style="font-size: 12px;">{{ $val->date }}</td>
                    <td style="font-size: 12px;">₱ {{ round($val->stotal) }}.00</td>
                    <td style="font-size: 12px;">₱ {{ round($val->etotal) }}.00</td>
                    <td style="font-size: 12px;">₱ {{ round($val->stotal - $val->etotal) }}.00</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>