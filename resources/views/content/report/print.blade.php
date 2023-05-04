<!DOCTYPE html>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>

<h2>Customer : {{$customer}}</h2>
<h2>Date : {{$dates}}</h2>

<table>
  <tr>
    <th>Transaction Date</th>
    <th>Description</th>
    <th>Credit</th>
    <th>Debit</th>
    <th>Amount</th>
  </tr>
  @foreach($datas as $data)
    <tr>
      <td>{{$data->TransactionDate}}</td>
      <td>{{$data->description}}</td>
      <td>{{$data->DebitCreditStatus == 'C' ? $data->Amount : '-'}}</td>
      <td>{{$data->DebitCreditStatus == 'D' ? $data->Amount : '-'}}</td>
      <td>{{$data->Amount}}</td>
    </tr>
  @endforeach
</table>

</body>
  <script type="text/javascript">
      window.print()
  </script>
</html>

