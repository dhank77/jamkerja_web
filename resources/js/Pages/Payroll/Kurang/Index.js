import React from 'react'
import Authenticated from '@/Layouts/Authenticated'
import { Link } from '@inertiajs/inertia-react'
import Paginate from '@/Components/Table/Paginate'
import Search from '@/Components/Table/Search'
import Delete from '@/Components/Crud/Delete'
import Edit from '@/Components/Crud/Edit'
import Dropdown from '@/Components/Crud/Dropdown'

export default function Index({ kurang }) {

    const { data, meta } = kurang

    return (
        <div>
            <div className="toolbar mb-5 mb-lg-7 d-flex justify-content-between">
                <div className="page-title d-flex flex-column me-3">
                    <h1 className="d-flex text-dark fw-bolder my-1 fs-3">Payroll</h1>
                    <ul className="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                        <li className="breadcrumb-item text-gray-600">
                            <a href="/" className="text-gray-600 text-hover-primary">Home</a>
                        </li>
                        <li className="breadcrumb-item text-gray-600">Daftar Pengurangan</li>
                        <li className="breadcrumb-item text-gray-500">Index</li>
                    </ul>
                </div>
                <div className="d-flex align-items-center py-2 py-md-1" >
                    <Link href={route('payroll.kurang.add')} className="btn btn-primary"><b>Tambah</b></Link>
                </div>
            </div>
            <div className="content">
                <div className="card mb-5 mb-xl-8">
                    <div className="card-header border-0 pt-5">
                        <h3 className="card-title align-items-start flex-column">
                            <span className="card-label fw-bolder fs-3 mb-1">Daftar Pengurangan Payroll</span>
                        </h3>
                    </div>
                    <div className="card-body py-3">
                        <Search />
                        <div className="table-responsive">
                            <table className="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3 min-h-200px">
                                <thead>
                                    <tr className="fw-bolder text-muted">
                                        <th>No</th>
                                        <th>Nama Komponen</th>
                                        <th>Periode</th>
                                        <th>Berdasarkan</th>
                                        <th>Detail</th>
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
                                                <span className="text-dark fw-bolder text-hover-primary fs-6">{u.kurang}</span>
                                            </td>
                                            <td>
                                                <p>{u.tanggal}</p>
                                            </td>
                                            <td>
                                                <p>{u.keterangan}</p>
                                            </td>
                                            <td>
                                                <p>{u.detail}</p>
                                            </td>
                                            <td>
                                                <Dropdown>
                                                    <Edit routes={route('payroll.kurang.edit', u.id)} />
                                                    <Delete routes={route('payroll.kurang.delete', u.id)} />
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