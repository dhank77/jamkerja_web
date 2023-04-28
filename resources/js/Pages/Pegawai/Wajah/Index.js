import UploadWajah from '@/Components/Modal/UploadWajah';
import Authenticated from '@/Layouts/Authenticated'
import React from 'react'
import Detail from '../Pegawai/Detail';

export default function Index({ pegawai, wajah }) {

    return (
        <Detail pegawai={pegawai} >
            <div className="card card-flush mt-6 mt-xl-9">
                <div className="card-header mt-5">
                    <div className="card-title flex-column">
                        <h3 className="fw-bolder mb-1">Data Wajah</h3>
                    </div>
                    <div class="card-toolbar">
                        <UploadWajah nip={pegawai.nip} />
                    </div>
                </div>
                <div className="card-body py-3">
                    <div class="row">
                        {
                            wajah.map((e, k) => (
                                <div className="col-md-6 col-lg-4 col-xl-3" key={k}>
                                    <div className="card h-100">
                                        <div className="card-body d-flex justify-content-center text-center flex-column p-8">
                                            <a href={e.file} target="_blank" className="text-gray-800 text-hover-primary d-flex flex-column align-items-center">
                                                <img src={e.file} className="w-40 rounded text-center" />
                                                <div className="fs-8 fw-bolder mb-2">{e.nama}</div>
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
