import Authenticated from '@/Layouts/Authenticated'
import { usePage } from '@inertiajs/inertia-react'
import React from 'react'
import Detail from '../Pegawai/Detail'

export default function Index({ pegawai }) {

    const { perusahaan } = usePage().props

    return (
        <Detail pegawai={pegawai}>
            <div className="card mb-5 mb-lg-10">
                <div className="card-header">
                    <div className="card-title">
                        <h3>Posisi & Jabatan</h3>
                    </div>
                </div>
                <div className="card-body p-0">
                    <div className="table-responsive">
                        <table className="table align-middle table-row-bordered table-row-solid gy-4 gs-9">
                            <tbody className="fw-6 fw-bold text-gray-600">
                                <tr>
                                    <td>
                                        <a href="#" className="text-hover-primary fs-5 text-gray-600">Instansi</a>
                                    </td>
                                    <td>
                                        <span className="badge badge-light-success fs-5 fw-bolder">{perusahaan.nama}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#" className="text-hover-primary fs-5 text-gray-600">Divisi Kerja</a>
                                    </td>
                                    <td>
                                        <span className="badge badge-light-success fs-5 fw-bolder">
                                            {pegawai.skpd}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#" className="text-hover-primary fs-5 text-gray-600">Jenis Jabatan</a>
                                    </td>
                                    <td>
                                        <span className="badge badge-light-primary fs-5 fw-bolder">
                                            {pegawai.jenis_jabatan}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#" className="text-hover-primary fs-5 text-gray-600">Status Pegawai</a>
                                    </td>
                                    <td>
                                        <span className="badge badge-light-primary fs-5 fw-bolder">
                                            {pegawai.status}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#" className="text-hover-primary fs-5 text-gray-600">Jabatan</a>
                                    </td>
                                    <td>
                                        <span className="badge badge-light-primary fs-5 fw-bolder">
                                            {pegawai.jabatan}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#" className="text-hover-primary fs-5 text-gray-600">Level Jabatan</a>
                                    </td>
                                    <td>
                                        <span className="badge badge-light-primary fs-5 fw-bolder">
                                            {pegawai.level}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#" className="text-hover-primary fs-5 text-gray-600">TMT Jabatan</a>
                                    </td>
                                    <td>
                                        <span className="badge badge-light-danger fs-5 fw-bolder">
                                            {pegawai.tmt_jabatan}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#" className="text-hover-primary fs-5 text-gray-600">Masa Kerja</a>
                                    </td>
                                    <td>
                                        <span className="badge badge-light-danger fs-5 fw-bolder">
                                            {pegawai.masa_kerja}
                                        </span>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </Detail>
    )
}

Index.layout = (page) => <Authenticated children={page} /> 