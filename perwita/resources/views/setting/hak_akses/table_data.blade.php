<table id="table_data" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Menu</th>
            <th>
            <div class="checkbox checkbox-info checkbox-circle">
                    <input  class="aktif_all" onchange="tes()" type="checkbox" name="aktif_all">
                    <label>
            Aktif
                        
                    </label>
            </div> 
            </th>
            <th>
            <div class="checkbox checkbox-info checkbox-circle">
                    <input  class="tambah_all" onchange="tes1()" type="checkbox" name="tambah_all">
                    <label>
            Tambah
                        
                    </label>
            </div> 
            </th>
            <th>
            <div class="checkbox checkbox-info checkbox-circle">
                    <input  class="ubah_all" onchange="tes2()" type="checkbox" name="ubah_all">
                    <label>
            Ubah
                        
                    </label>
            </div> 
            </th>
            <th>
            <div class="checkbox checkbox-info checkbox-circle">
                    <input  class="hapus_all" onchange="tes3()" type="checkbox" name="hapus_all">
                    <label>
            Hapus
                        
                    </label>
            </div> 
            </th>
            <th>
            <div class="checkbox checkbox-info checkbox-circle">
                    <input  class="cabang_all" onchange="tes4()" type="checkbox" name="cabang_all">
                    <label>
            Cabang
                        
                    </label>
            </div> 
            </th>
            <th>
            
            <div class="checkbox checkbox-info checkbox-circle">
                    <input  class="print_all" onchange="tes5()" type="checkbox" name="print_all">
                    <label>
                        Print
                    </label>
            </div> 
            </th>
            <th>
            
            <div class="checkbox checkbox-info checkbox-circle">
                    <input  class="global_all" onchange="tes6()" type="checkbox" name="global_all">
                    <label>
                        Global
                    </label>
            </div> 
            </th>
        </tr>
    </thead>
    <tbody>

        @foreach($data as  $i)
        <tr>
            <td>{{$i->mm_nama}}</td>
            <td align="center">
                <div class="checkbox checkbox-info checkbox-circle">
                    <input  class="aktif" type="checkbox" name="aktif">
                    <label>
                        
                    </label>
                </div> 
            </td>
            <td align="center">
                <div class="checkbox checkbox-info checkbox-circle">
                    <input  class="tambah" type="checkbox" name="tambah">
                    <label>
                        
                    </label>
                </div> 
            </td>
            <td align="center">
                <div class="checkbox checkbox-info checkbox-circle">
                    <input  class="ubah" type="checkbox" name="ubah">
                    <label>
                        
                    </label>
                </div> 
            </td>
            <td align="center">
                <div class="checkbox checkbox-info checkbox-circle">
                    <input  class="hapus" type="checkbox" name="hapus">
                    <label>
                        
                    </label>
                </div> 
            </td>
            <td align="center">
                <div class="checkbox checkbox-info checkbox-circle">
                    <input  class="cabang" type="checkbox" name="cabang">
                    <label>
                        
                    </label>
                </div> 
            </td>
            <td align="center">
                <div class="checkbox checkbox-info checkbox-circle">
                    <input  class="print" type="checkbox" name="print">
                    <label>
                        
                    </label>
                </div> 
            </td>
            <td align="center">
                <div class="checkbox checkbox-info checkbox-circle">
                    <input  class="global" type="checkbox" name="global">
                    <label>
                        
                    </label>
                </div> 
            </td>
            
        </tr>
        @endforeach
    </tbody>
</table>