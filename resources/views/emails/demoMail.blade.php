<!DOCTYPE html>
	<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>測試發信</title>
</head>
<body>
	<table border="1" width="300px;">
		<caption>{{ session('month') }}報表</caption>
		<thead>
			<tr>
				<th>name</th>
				<th>cost_total</th>
			</tr>
		</thead>
		<tbody>
		@foreach($mailDatas as $mailData)	
			<tr>
				<td align="center">{{ $mailData['name'] }}</td>
				<td align="center">{{ $mailData['total'] }}</td>
			</tr>
		@endforeach	
		</tbody>
	</table>
</body>
</html>