import Delete from '@/Components/Crud/Delete';
import Dropdown from '@/Components/Crud/Dropdown';
import Edit from '@/Components/Crud/Edit';
import Paginate from '@/Components/Table/Paginate';
import Search from '@/Components/Table/Search';
import Authenticated from '@/Layouts/Authenticated'
import { Link } from '@inertiajs/inertia-react';
import React from 'react'

export default function Index({ perusahaan }) {

    const { data, meta } = perusahaan

    return (
        <div>
            <div className="toolbar mb-5 mb-lg-7 d-flex justify-content-between">
                <div className="page-title d-flex flex-column me-3">
                    <h1 className="d-flex text-dark fw-bolder my-1 fs-3">Perusahaan</h1>
                    <ul className="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                        <li className="breadcrumb-item text-gray-600">
                            <a href="/" className="text-gray-600 text-hover-primary">Home</a>
                        </li>
                        <li className="breadcrumb-item text-gray-500">Index</li>
                    </ul>
                </div>
                <div className="d-flex align-items-center py-2 py-md-1" >
                    <Link href={route('perusahaan.add')} className="btn btn-primary"><b>Tambah</b></Link>
                </div>
            </div>
            <div className="card mb-5 mb-xl-8">
                <div className="card-header border-0 pt-5">
                    <h3 className="card-title align-items-start flex-column">
                        <span className="card-label fw-bolder fs-3 mb-1">Data Perusahaan</span>
                    </h3>
                </div>
                <div className="card-body py-3">
                    <div className='mb-4'>
                        <Search />
                    </div>
                    <div className="table-responsive">
                        <table className="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3 min-h-200px">
                            <thead>
                                <tr className="fw-bolder text-muted">
                                    <th>
                                        No
                                    </th>
                                    <th>
                                        Kode
                                    </th>
                                    <th>
                                        Nama
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                    <th>
                                        Jumlah Pegawai
                                    </th>
                                    <th>
                                        Maks Pegawai
                                    </th>
                                    <th>
                                        Expired Date
                                    </th>
                                    <th>
                                        Edit
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                {
                                    data && data.map((u, k) => (
                                        <tr key={k}>
                                            <td>
                                                <div>{k + 1}</div>
                                            </td>
                                            <td>
                                                <div>{u.kode_perusahaan}</div>
                                            </td>
                                            <td>
                                                {u.nama}
                                            </td>
                                            <td>
                                                {u.status}
                                            </td>
                                            <td>
                                                {u.jumlah_pegawai}
                                            </td>
                                            <td>
                                                {u.jumlah_pegawai}
                                            </td>
                                            <td>
                                                {u.expired_at}
                                            </td>
                                            <td>
                                                <Dropdown>
                                                    <Edit routes={route('perusahaan.edit', u.kode_perusahaan)} />
                                                </Dropdown>
                                            </td>
                                        </tr>
                                    ))
                                }
                            </tbody>
                        </table>
                    </div>
                    <div className='mt-4'>
                        <Paginate meta={meta} />
                    </div>
                </div>
            </div>
        </div>
    )
}

Index.layout = (page) => <Authenticated children={page} />