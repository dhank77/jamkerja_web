import React from 'react'
import Authenticated from '@/Layouts/Authenticated'
import { Link } from '@inertiajs/inertia-react'
import Paginate from '@/Components/Table/Paginate'
import Search from '@/Components/Table/Search'
import Delete from '@/Components/Crud/Delete'
import Edit from '@/Components/Crud/Edit'
import Dropdown from '@/Components/Crud/Dropdown'
import JksModal from '@/Components/Modal/JksModal'

export default function Index({ jamKerjaStatis }) {

    const { data, meta } = jamKerjaStatis

    return (
        <div>
            <div className="toolbar mb-5 mb-lg-7 d-flex justify-content-between">
                <div className="page-title d-flex flex-column me-3">
                    <h1 className="d-flex text-dark fw-bolder my-1 fs-3">Master</h1>
                    <ul className="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                        <li className="breadcrumb-item text-gray-600">
                            <a href="/" className="text-gray-600 text-hover-primary">Home</a>
                        </li>
                        <li className="breadcrumb-item text-gray-600">Jam Kerja - Statis</li>
                        <li className="breadcrumb-item text-gray-500">Index</li>
                    </ul>
                </div>
                <div className="d-flex align-items-center py-2 py-md-1" >
                    <Link href={route('master.jamKerjaStatis.add')} className="btn btn-primary"><b>Tambah</b></Link>
                </div>
            </div>
            <div className="content">
                <div className="card mb-5 mb-xl-8">
                    <div className="card-header border-0 pt-5">
                        <h3 className="card-title align-items-start flex-column">
                            <span className="card-label fw-bolder fs-3 mb-1">Data Jam Kerja Statis</span>
                        </h3>
                    </div>
                    <div className="card-body py-3">
                        <Search />
                        <div className="table-responsive">
                            <table className="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3 min-h-300px">
                                <thead>
                                    <tr className="fw-bolder text-muted">
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Jam datang / Jam Pulang / Toleransi Telat Datang / Toleransi Pulang Cepat</th>
                                        <th>Jumlah Pegawai</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {data && data.map((u, k) => (
                                        <tr key={k}>
                                            <td>
                                                {k + 1}
                                            </td>
                                            <td>
                                                <span className="text-dark fw-bolder text-hover-primary fs-6">{u.nama}</span>
                                            </td>
                                            <td>
                                                <div dangerouslySetInnerHTML={{ __html : u.jadwal }}/>
                                            </td>
                                            <td>
                                                <span className="text-dark fw-bolder text-hover-primary fs-6">{u.jumlah_pegawai}</span>
                                            </td>
                                            <td>
                                                <Dropdown>
                                                    <JksModal kode_jam_kerja={u.kode_jam_kerja} />
                                                    <Edit routes={route('master.jamKerjaStatis.edit', u.kode_jam_kerja)} />
                                                    <Delete routes={route('master.jamKerjaStatis.delete', u.kode_jam_kerja)} />
                                                </Dropdown>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <Paginate meta={meta} />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}

Index.layout = (page) => <Authenticated children={page} />