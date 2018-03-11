<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=nilai.xlsx");
?>

<table>
 <tr>
  <th>NO</th>
  <th>NPM</th>
  <th>NAMA</th>
  <th>KEHADIRAN</th>
  <th>UTS</th>
  <th>UAS</th>
  <th>NILAI MUTU</th>
 </tr>
 <tr>
  <td align="center">1</td>
  <td>TI1091001</td>
  <td>DENDIE SANJAYA</td>
  <td align="center">100%</td>
  <td align="center">90</td>
  <td align="center">95</td>
  <td align="center">A</td>
 </tr>
 <tr>
  <td align="center">2</td>
  <td>TI1091002</td>
  <td>AINUR ROFIQ</td>
  <td align="center">85%</td>
  <td align="center">86</td>
  <td align="center">90</td>
  <td align="center">A</td>
 </tr>
 <tr>
  <td align="center">3</td>
  <td>TI1091003</td>
  <td>RAHMAT</td>
  <td align="center">70%</td>
  <td align="center">70</td>
  <td align="center">75</td>
  <td align="center">B</td>
 </tr>
</table> 

<?php
exit()
?>