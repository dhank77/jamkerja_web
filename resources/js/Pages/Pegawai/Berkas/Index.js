import Authenticated from '@/Layouts/Authenticated'
import React from 'react'
import Detail from '../Pegawai/Detail';

export default function Index({ pegawai, dataFile }) {

    return (
        <Detail pegawai={pegawai} >
            <div className="card card-flush mt-6 mt-xl-9">
                <div className="card-header mt-5">
                    <div className="card-title flex-column">
                        <h3 className="fw-bolder mb-1">Unduh Berkas</h3>
                        <div className="fs-6 text-gray-400">Data seluruh file</div>
                    </div>
                    <div class="card-toolbar">
                        {
                            dataFile.length > 0 &&
                            <a href={route('pegawai.berkas.berkas_zip', pegawai.nip)} class="btn btn-primary fw-bolder me-auto px-4 py-3">Download semua berkas (Zip File)</a>
                        }
                    </div>
                </div>
                <div className="card-body py-3">
                    <div class="row">
                        {
                            dataFile.map((e, k) => (
                                <div className="col-md-6 col-lg-4 col-xl-3">
                                    <div className="card h-100">
                                        <div className="card-body d-flex justify-content-center text-center flex-column p-8">
                                            <a href={e.file} target="_blank" className="text-gray-800 text-hover-primary d-flex flex-column">
                                                <div className="symbol symbol-60px mb-5">
                                                    {
                                                        e.extension == 'pdf' ?
                                                            <img src={`/assets/media/svg/files/pdf.svg`} alt /> :
                                                            <div className='d-flex justify-center'>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="65" height="65" fill="currentColor" className="bi bi-card-image text-primary" viewBox="0 0 16 16">
                                                                    <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                                                                    <path d="M1.5 2A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13zm13 1a.5.5 0 0 1 .5.5v6l-3.775-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12v.54A.505.505 0 0 1 1 12.5v-9a.5.5 0 0 1 .5-.5h13z" />
                                                                </svg>
                                                            </div>
                                                    }
                                                </div>
                                                <div className="fs-5 fw-bolder mb-2">{e.nama}</div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            ))
                        }
                    </div>
                </div>
            </div>
        </Detail>
    )
}

Index.layout = (page) => <Authenticated children={page} />
