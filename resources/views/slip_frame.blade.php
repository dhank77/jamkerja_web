<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji</title>
</head>
<body>
    <div>
        <iframe width="1400px" height="1000px" src="{{ route("payroll.generate.slip", ["kode_payroll" => $kode_payroll, "nip" => $nip]) }}" frameborder="0"></iframe>
    </div>
</body>
</html>