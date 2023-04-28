import { Inertia } from '@inertiajs/inertia';
import React from 'react'
import Swal from 'sweetalert2';

export default function ResetImei({ routes }) {

    const deleteData = () => {
        Swal.fire({
            title: 'Yakin mereset seluruh imei anda?',
            text: "Data tidak dapat dikembalikan!",
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
        <div>
            <button onClick={() => deleteData()} className="btn btn-success mr-2"><b>Reset Imei</b></button>
        </div>
    )
}
