import { Inertia } from '@inertiajs/inertia';
import React from 'react'
import Swal from 'sweetalert2';

export default function Reset({ routes }) {

    const deleteData = () => {
        Swal.fire({
            title: 'Yakin mereset data lokasi & radius?',
            text: "Data tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!'
        }).then((result) => {
            if (result.isConfirmed) {
                Inertia.post(routes);
            }
        })
    }

    return (
        <div className="dropdown-item  menu-item px-3">
            <a href="#" onClick={() => deleteData()} className="menu-link px-3"><i className='bi bi-diamond-half mr-2 text-warning'></i> Reset </a>
        </div>
    )
}
