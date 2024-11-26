$(document).ready(function() {
    $('#btnTambah').click(function() {
        $('#formDiv').toggle();
    });

    $('#createForm').submit(function(e) {
        e.preventDefault();
        var nama = $('#nama').val();
        var merk = $('#merk').val();
        var satuan = $('#satuan').val();
        var jumlah = $('#jumlah').val();
        var harga = $('#harga').val();

        $.ajax({
            url: 'soapClient.php',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ action: 'create', nama: nama, merk: merk, satuan: satuan, jumlah: jumlah, harga: harga }),
            success: function(response) {
                alert('Jam tangan berhasil ditambahkan!');
                loadJamTangan();
                $('#createForm')[0].reset();
                $('#formDiv').hide();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error: ' + textStatus + ' - ' + errorThrown);
            }
        });
    });

    function loadJamTangan() {
        $.ajax({
            url: 'soapClient.php',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ action: 'read' }),
            success: function(response) {
                var jamTanganList = JSON.parse(response);
                var jamTanganDiv = $('#jamTanganList');
                jamTanganDiv.empty();

                var table = $('<table class="table table-bordered"><thead><tr><th>Id</th><th>Nama</th><th>Merk</th><th>Satuan</th><th>Jumlah</th><th>Harga</th><th>Action</th></tr></thead><tbody></tbody></table>');
                jamTanganList.forEach(function(jamTangan) {
                    var row = $('<tr></tr>');
                    row.append('<td>' + jamTangan.id + '</td>');
                    row.append('<td>' + jamTangan.nama + '</td>');
                    row.append('<td>' + jamTangan.merk + '</td>');
                    row.append('<td>' + jamTangan.satuan + '</td>');
                    row.append('<td>' + jamTangan.jumlah + '</td>');
                    row.append('<td>' + jamTangan.harga + '</td>');
                    row.append('<td><button class="btn btn-primary" onclick="editJamTangan(' + jamTangan.id + ')">Edit</button> <button class="btn btn-danger" onclick="deleteJamTangan(' + jamTangan.id + ')">Delete</button></td>');
                    table.find('tbody').append(row);
                });
                jamTanganDiv.append(table);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error: ' + textStatus + ' - ' + errorThrown);
            }
        });
    }

    loadJamTangan();

    window.editJamTangan = function(id) {
        // Implementasi untuk mengedit data jam tangan
    };

    window.deleteJamTangan = function(id) {
        $.ajax({
            url: 'soapClient.php',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ action: 'delete', id: id }),
            success: function(response) {
                alert('Jam tangan berhasil dihapus!');
                loadJamTangan();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error: ' + textStatus + ' - ' + errorThrown);
            }
        });
    };
});
