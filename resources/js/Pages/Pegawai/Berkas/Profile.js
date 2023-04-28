import Authenticated from '@/Layouts/Authenticated'
import React from 'react'
import Iframe from 'react-iframe';
import Detail from '../Pegawai/Detail';

export default function Profile({ pegawai }) {

    return (
        <Detail pegawai={pegawai} >
            <div className="card card-flush mt-6 mt-xl-9">
                <div className="card-header mt-5">
                    <div className="card-title flex-column">
                        <h3 className="fw-bolder mb-1">Unduh Profile</h3>
                    </div>
                </div>
                <div className="card-body py-3">
                    <div class="row">
                        <Iframe width='100%' height='500px' url={route('pegawai.berkas.profile_pdf', { nip: pegawai.nip })} />
                    </div>
                </div>
            </div>
        </Detail>
    )
}

Profile.layout = (page) => <Authenticated children={page} />
