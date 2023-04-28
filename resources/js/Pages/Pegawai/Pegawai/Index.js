import React, { useEffect, useState } from 'react'
import Authenticated from '@/Layouts/Authenticated'
import { Link, usePage } from '@inertiajs/inertia-react'
import Paginate from '@/Components/Table/Paginate'
import Search from '@/Components/Table/Search'
import Delete from '@/Components/Crud/Delete'
import Edit from '@/Components/Crud/Edit'
import Dropdown from '@/Components/Crud/Dropdown'
import Detail from '@/Components/Crud/Detail'

export default function Index({ pegawai }) {

    const { data, meta } = pegawai

    const [key, setKey] = useState("pegawai.pegawai.detail")
    const { auth } = usePage().props;

    useEffect(() => {
        const getActiveLink = JSON.parse(localStorage.getItem("linkDetail"));
        if (getActiveLink) {
            setKey(getActiveLink);
        }
    }, []);

    return (
        <div>
            <div className="toolbar mb-5 mb-lg-7">
                <div className="page-title d-flex flex-column me-3">
                    <h1 className="d-flex text-dark fw-bolder my-1 fs-3">Pegawai</h1>
                    <ul className="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                        <li className="breadcrumb-item text-gray-600">
                            <a href="/" className="text-gray-600 text-hover-primary">Home</a>
                        </li>
                        <li className="breadcrumb-item text-gray-600">Data</li>
                        <li className="breadcrumb-item text-gray-500">Index</li>
                    </ul>
                </div>
                {
                    auth.role.some(ar => ['admin', 'owner'].includes(ar)) &&
                    <div className="d-flex align-items-center py-2 py-md-1" >
                        <Link href={route('pegawai.pegawai.add')} className="btn btn-primary"><b>Tambah</b></Link>
                    </div>
                }
            </div>
            <div className="content">
                <div className="card mb-5 mb-xl-8">
                    <div className="card-header border-0 pt-5">
                        <h3 className="card-title align-items-start flex-column">
                            <span className="card-label fw-bolder fs-3 mb-1">Data pegawai</span>
                        </h3>
                    </div>
                    <div className="card-body py-3">
                        <Search />
                        <div className="table-responsive">
                            <table className="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3 min-h-200px">
                                <thead>
                                    <tr className="fw-bolder text-muted">
                                        <th>No</th>
                                        <th>
                                            Foto
                                        </th>
                                        <th>
                                            No. Pegawai
                                            <br />
                                            Nama Lengkap
                                        </th>
                                        <th>
                                            Jabatan
                                            <br />
                                            Divisi
                                        </th>
                                        <th>Level</th>
                                        <th>
                                            No HP / WA
                                            <br />
                                            Email
                                        </th>
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
                                                <div className="symbol symbol-50px me-2">
                                                    <span className="symbol-label">
                                                        <img src={u.images} className="h-75 align-self-end" alt="images" />
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <Link href={route(key, u.nip)} className="text-dark fw-bolder text-hover-primary fs-6">{u.nip}</Link> <br />
                                                <Link href={route(key, u.nip)} className="text-dark fw-bolder text-hover-primary fs-6">{u.name}</Link>
                                            </td>
                                            <td>
                                                <p>{u.nama_jabatan}</p>
                                                <p>{u.skpd}</p>
                                            </td>
                                            <td>
                                                <p>{u.eselon}</p>
                                            </td>
                                            <td>
                                                <p>{u.no_hp}</p>
                                                <p>{u.email}</p>
                                            </td>
                                            <td>
                                                <Dropdown>
                                                    <Detail routes={route(key, u.nip)} />
                                                    <Edit routes={route('pegawai.pegawai.edit', u.nip)} />
                                                    <Delete routes={route('pegawai.pegawai.delete', u.nip)} />
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