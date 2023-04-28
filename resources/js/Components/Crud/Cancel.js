import { Inertia } from '@inertiajs/inertia';
import React from 'react'
import Swal from 'sweetalert2';

export default function Cancel({ routes }) {

    const handleClick = () => {
        Swal.fire({
            title: 'Apakah anda yakin membatalkan data ini?',
            text: "Mohon diperhatikan kembali!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!'
        }).then((result) => {
            if (result.isConfirmed) {
                Inertia.get(routes);
            }
        })
    }

    return (
        <div className="dropdown-item  menu-item px-3">
            <a href="#" onClick={() => handleClick()} className="menu-link px-3"><i className='fa fa-ban mr-2 text-danger'></i> Batalkan </a>
        </div>
    )
}
