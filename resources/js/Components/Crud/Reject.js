import { Inertia } from '@inertiajs/inertia';
import React, { useEffect, useState } from 'react'
import Swal from 'sweetalert2';

export default function Reject({ routes }) {

    const deleteData = async () => {
        const { value: text } = await Swal.fire({
            input: 'textarea',
            inputLabel: 'Masukkan Alasan Penolakan',
            inputPlaceholder: 'Tulis Disini...',
            inputAttributes: {
              'aria-label': 'Tulis Disini'
            },
            showCancelButton: true
          })
          
          if (text) {
            Inertia.post(routes, {komentar: text})
          }else{
            Swal.fire("Terjadi Kesalahan", "Alasan Penolakan wajib diisi", 'error');
          }
    }

    


    return (
        <div className="dropdown-item  menu-item px-3">
            <a href="#" onClick={() => deleteData()} className="menu-link px-3"><b><i className='fa fa-ban mr-2 text-danger'></i> Tolak</b> </a>
        </div>
    )
}
