import Swal from 'sweetalert2';

// Fungsi untuk menampilkan notifikasi
export function showAlert(icon, title, text) {
    Swal.fire({
        icon: icon,
        title: title,
        text: text,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000, // Notifikasi akan hilang setelah 3 detik
        timerProgressBar: true,
    });
}


export function handleFlashMessages(page) {
    console.log(page); // Periksa struktur page
    console.log(page?.props); // Periksa apakah props ada
    console.log(page?.props?.flash); // Periksa apakah flash ada

    if (page?.props?.flash) {
        if (page.props.flash.error) {
            showAlert('error', 'Error', page.props.flash.error);
        }

        if (page.props.flash.success) {
            showAlert('success', 'Success', page.props.flash.success);
        }
    }
}