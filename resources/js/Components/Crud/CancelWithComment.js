import { Inertia } from '@inertiajs/inertia';
import React from 'react'
import Swal from 'sweetalert2';

export default function CancelWithComment({ routes }) {

    const handleClick = async () => {
        const { value: text } = await Swal.fire({
            input: 'textarea',
            inputLabel: 'Masukkan Alasan Membatalakan',
            inputPlaceholder: 'Tulis Disini...',
            inputAttributes: {
              'aria-label': 'Tulis Disini'
            },
            showCancelButton: true
          })
          
          if (text) {
            Inertia.post(routes, {komentar: text})
          }else{
            Swal.fire("Terjadi Kesalahan", "Alasan Membatalakan wajib diisi", 'error');
          }
    }

    return (
        <div className="dropdown-item  menu-item px-3">
            <a href="#" onClick={() => handleClick()} className="menu-link px-3"><i className='fa fa-ban mr-2 text-danger'></i> Batalkan </a>
        </div>
    )
}
