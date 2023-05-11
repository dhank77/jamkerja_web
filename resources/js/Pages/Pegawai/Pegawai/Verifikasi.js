import UploadWajah from '@/Components/Modal/UploadWajah';
import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import React from 'react'
import Swal from 'sweetalert2';

export default function Verifikasi({ pegawai }) {

    const updateWajah = (nip) => {
        Swal.fire({
            title: 'Apakah anda yakin mengubah data ini?',
            text: "Data tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!'
        }).then((result) => {
            if (result.isConfirmed) {
                Inertia.post(route('pegawai.wajah.update', nip));
            }
        })
    }
    
    const updateWajahAll = (nip) => {
        Swal.fire({
            title: 'Apakah anda yakin mengubah data ini?',
            text: "Data tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!'
        }).then((result) => {
            if (result.isConfirmed) {
                Inertia.post(route('pegawai.pegawai.update_wajah'));
            }
        })
    }

    return (
        <div className="card card-flush mt-6 mt-xl-9">
            <div className="card-header mt-5">
                <div className="card-title flex-column">
                    <h3 className="fw-bolder mb-1">Verifikasi Data Wajah</h3>
                </div>
                <div class="card-toolbar">
                    <button onClick={updateWajahAll} className="btn btn-success mr-2"><b>Jadikan Semua Profile Menjadi Verifikasi Wajah</b></button>
                </div>
            </div>
            <div className="card-body py-3">
                <div class="row">
                    {
                        pegawai && pegawai.map((e, k) => (
                            <div className="col-md-4 col-lg-4 col-xl-2" key={k}>
                                <div className="card h-100">
                                    <div className="card-body d-flex justify-content-center text-center flex-column p-8">
                                        <a href={e.images} target="_blank" className="text-gray-800 text-hover-primary d-flex flex-column align-items-center">
                                            <img src={e.images} className="w-40 rounded text-center" />
                                            <div className="fs-8 fw-bolder mb-2">{e.name}</div>
                                        </a>
                                        {e.images != "http://jamkerja.test/no-image.png" && (
                                            <div className="ml-3">
                                                <button onClick={() => updateWajah(e.nip)} className="badge badge-primary mt-2">
                                                    Jadikan Foto Presensi
                                                </button>
                                            </div>
                                        )}
                                    </div>
                                </div>
                            </div>
                        ))
                    }
                </div>
            </div>
        </div>
    )
}

Verifikasi.layout = (page) => <Authenticated children={page} />
