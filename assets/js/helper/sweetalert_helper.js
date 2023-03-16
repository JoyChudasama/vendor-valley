import Swal from 'sweetalert2';

const showToast = (props) => {

    const Toast = Swal.mixin({
        toast: true,
        position: props.position ? props.position : 'top-end',
        title: props.title,
        icon: props.icon,
        showConfirmButton: props.isShowConfirmButton || false,
        timer: props.timer,
        timerProgressBar: props.isShowTimeProgressBar || true,
        customClass: props.customClass,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    Toast.fire();
}

export { showToast };