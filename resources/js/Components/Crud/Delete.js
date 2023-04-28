import { Inertia } from '@inertiajs/inertia';
import React from 'react'
import Swal from 'sweetalert2';

export default function Delete({ routes }) {

    const deleteData = () => {
        Swal.fire({
            title: 'Apakah anda yakin menghapus data ini?',
            text: "Data tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!'
        }).then((result) => {
            if (result.isConfirmed) {
                Inertia.delete(routes);
            }
        })
    }

    return (
        <div className="dropdown-item  menu-item px-3">
            <a href="#" onClick={() => deleteData()} className="menu-link px-3"><i className='fa fa-trash mr-2 text-danger'></i> Delete </a>
        </div>
    )
}
