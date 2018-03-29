<style>
	.pembungkus{
		width: 100%;
	}
	table {
    border-collapse: collapse;
	}
	table,th,td{
	border :1px solid black;
	}

	.page-break	{
		page-break-after: always;
	}

</style>

<div class=" pembungkus">
	<table id="addColumn" class="table table_header table-bordered table-striped"> 
                    <thead>
                    <tr>
                      <th  style="text-align: center"> No.</th>                      
                      <th  style="text-align: center"> Nota</th>
                      <th  style="text-align: center"> Tgl </th>
                      <th  style="text-align: center"> Masa pajak </th>
                      <th  style="text-align: center"> Dpp</th>
                      <th  style="text-align: center"> Hasil Ppn</th>
                      <th  style="text-align: center"> Jenis PPN </th>
                      <th  hidden=""></th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach ($array as $index => $element)
                    <tr>
                      <td><input type="hidden" name="" value="{{ $element->fpm_id }}"> {{ $index+1 }} </td>
                      <td><input type="hidden" name="" value="{{ $element->fpm_nota }}">  {{ $element->fpm_nota }}  </td>
                      <td><input type="hidden" name="" value="{{ $element->fpm_tgl }}">  {{ $element->fpm_tgl }}  </td>
                      <td><input type="hidden" name="" value="{{ $element->fpm_masapajak }}">  {{ $element->fpm_masapajak }} </td>
                      <td><input type="hidden" name="" value="{{ $element->fpm_dpp }}">  {{ $element->fpm_dpp }}</td>
                      <td><input type="hidden" name="" value="{{ $element->fpm_hasilppn  }}"> {{ $element->fpm_hasilppn  }}</td>
                      <td><input type="hidden" name="" value="{{ $element->fpm_jenisppn }}">  
                        @if ($element->fpm_jenisppn === 'E')
                            Exclude
                        @elseif ($element->fpm_jenisppn === 'I')
                            Include
                        @else
                            Tanpa
                        @endif
                          
                        
                        
                      </td>
                      <td hidden=""><input type="hidden" name="" value=""></td>

                    </tr>
                    @endforeach
                    </tbody>
                  </table>
</div>
