<?php
date_default_timezone_set('Asia/Jakarta');
echo'
<table class="table table-striped table-bordered" id="tbl" border="1">
    <thead>
        <tr style="font-weight:bold">
            <th style="text-align: center;" width="4%"> No </th>
            <th style="text-align: center;"> Judul Instruksi </th>
            <th style="text-align: center;"> Deskripsi </th>
            <th style="text-align: center;"> Waktu </th>
            <th style="text-align: center;"> Wilayah </th>
            <th style="text-align: center;"> Pengusul </th>
            <th style="text-align: center;"> Status Pengusulan </th>
            <th style="text-align: center;"> Status Pengerjaan </th>
        </tr>
    </thead>
    <tbody>';
    $no = 1;
    foreach ($data_utama as $key => $value) {
        echo'<tr>';
        echo '<td style="text-align: center;">'.$no++.'.'.'</td>';
        echo '<td style="text-align: center;">'.$value['judul'].'</td>';
        echo '<td style="text-align: center;">'.$value['deskripsi'].'</td>';
        $url2 = 'http://pradi.is-very-good.org:7733/api/relawanprofiles/getProfile/'.$value['idRelawan'];
        $data_relawan = $this->Main_model->getAPI($url2);
        echo '<td style="text-align: center;">'.$data_relawan['namaRelawan'].'</td>';
        echo '<td style="text-align: center;">'.$this->Main_model->convert_tanggal(substr($value['waktu'],0,10)).'</td>';
        $wilayah = '';
        if(strlen($value['idWilayah'])=='2'){
            $url3 = 'http://pradi.is-very-good.org:7733/api/prov/id/'.$value['idWilayah'];
            $data_prov = $this->Main_model->getAPI($url3);
            $wilayah = $data_prov['namaProvinsi'];
        }elseif(strlen($value['idWilayah'])=='4'){
            $url3 = 'http://pradi.is-very-good.org:7733/api/kab/id/'.$value['idWilayah'];
            $data_kab = $this->Main_model->getAPI($url3);
            $wilayah = $data_kab['namaKabupaten'];
        }elseif(strlen($value['idWilayah'])=='7'){
            $url3 = 'http://pradi.is-very-good.org:7733/api/kec/id/'.$value['idWilayah'];
            $data_kab = $this->Main_model->getAPI($url3);
            $wilayah = $data_kab['namaKecamatan'];
        }elseif(strlen($value['idWilayah'])=='10'){
            $url3 = 'http://pradi.is-very-good.org:7733/api/desa/id/'.$value['idWilayah'];
            $data_kab = $this->Main_model->getAPI($url3);
            $wilayah = $data_kab['namaDesa'];
        }else{
            echo'';
        }
        echo'<td style="text-align: center;"> '.$wilayah.' </td>';
        if($value['isApprove']=='false'){
            echo'<td style="text-align: center;"> Pending </td>';
        }else{
            echo'<td style="text-align: center;"> Disetujui </td>';
        }
        $return_on_click = "return confirm('Anda yakin?')";
        if($value['isDone']=='false'){
            echo'<td style="text-align: center;"> Belum Selesai </td>';
        }else{
            echo'<td style="text-align: center;"> Selesai </td>';
        }
        echo'</tr>';
    }
    echo'</tbody>';
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=rekap_data.xls");
echo'</table>
';
?>