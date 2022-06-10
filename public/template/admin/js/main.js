$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function removeRow(id, url) {
    if (confirm('Bạn có chắc chắn muốn xóa ?')) {
        $.ajax({
            type: 'DELETE',
            datatype: 'JSON',
            data: { id },
            url: url,
            success: function(result) {
                if (result.error === false) {
                    alert(result.message);
                    location.reload();
                } else {
                    alert('Delete Error! Vui lòng thử lại!');
                }
            }
        })
    }
}

// $('#upload').change(function() {
//     const form = new FormData();
//     form.append('file', $(this)[0].files[0]);

//     $.ajax({
//         processData: false,
//         contentType: false,
//         type: 'POST',
//         dataType: 'JSON',
//         data: form,
//         url: '/admin/upload/services',
//         success: function(results) {
//             // if (results.error === false) {
//             //     $('#image_show').html('<a href="' + results.url + '" target="_blank">' +
//             //         '<img src="' + results.url + '" width="100px"></a>');

//             //     $('#thumb').val(results.url);
//             // } else {
//             //     alert('Upload File Lỗi');
//             // }

//         }
//     });
// });
// $('#upload').change(function() {

//     let reader = new FileReader();

//     reader.onload = (e) => {

//         $('#image_preview_container').attr('src', e.target.result);
//     }

//     reader.readAsDataURL(this.files[0]);

// });
// $('#product-form').submit(function(e) {

//     e.preventDefault();

//     var formData = new FormData(this);

//     $.ajax({
//         type: 'POST',
//         url: "{{ url('photo')}}",
//         data: formData,
//         cache: false,
//         contentType: false,
//         processData: false,
//         success: (data) => {
//             this.reset();
//             alert('Image has been uploaded successfully');
//         },
//         error: function(data) {
//             console.log(data);
//         }
//     });
// });