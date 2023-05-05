import React, { useEffect, useState } from 'react'
import Authenticated from '@/Layouts/Authenticated'
import Paginate from '@/Components/Table/Paginate'
import Search from '@/Components/Table/Search'
import { usePrevious } from 'react-use'
import { Inertia } from '@inertiajs/inertia'

export default function Index({ visits }) {

    const { data, meta } = visits


    const [query, setQuery] = useState({
        d: meta.date,
        e: meta.end,
    });
    

    const prev = usePrevious(query);

    useEffect(() => {
        if (prev) {
            Inertia.get(route(route().current()), query, {
                replace: true,
                preserveState: true
            })
        }
    }, [query])

    return (
        <div>
            <div className="toolbar mb-5 mb-lg-7 d-flex justify-content-between">
                <div className="page-title d-flex flex-column me-3">
                    <h1 className="d-flex text-dark fw-bolder my-1 fs-3">Kunjungan</h1>
                    <ul className="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                        <li className="breadcrumb-item text-gray-600">
                            <a href="/" className="text-gray-600 text-hover-primary">Home</a>
                        </li>
                        <li className="breadcrumb-item text-gray-600">Data</li>
                    </ul>
                </div>
                <div className="d-flex align-items-center justify-content-between">
                    <input type="date" name="d" id="d" className="form-control" value={query.d} onChange={(e) => setQuery({ ...query, d: e.target.value })} />
                    <div className="mx-2"> - </div>
                    <input type="date" name="e" id="e" className="form-control" value={query.e} onChange={(event) => setQuery({ ...query, e: event.target.value })} />
                </div>
            </div>
            <div className="content">
                <div className="card mb-5 mb-xl-8">
                    <div className="card-header border-0 pt-5">
                        <h3 className="card-title align-items-start flex-column">
                            <span className="card-label fw-bolder fs-3 mb-1">Data Harian Kunjungan</span>
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
                                            Nama
                                        </th>
                                        <th>Tanggal</th>
                                        <th>Judul</th>
                                        <th>Keterangan</th>
                                        <th>Lokasi</th>
                                        <th>Foto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {data && data.map((u, k) => (
                                        <tr key={k}>
                                            <td>
                                                {k + 1}
                                            </td>
                                            <td>
                                                <div className="text-dark fw-bolder text-hover-primary fs-6">{u.nama}</div>
                                            </td>
                                            <td>
                                                <p>{u.tanggal}</p>
                                            </td>
                                            <td>
                                                <p>{u.judul}</p>
                                            </td>
                                            <td>
                                                <p>{u.keterangan}</p>
                                            </td>
                                            <td>
                                                <p>{u.kordinat}</p>
                                                <div className="text-dark fw-bolder text-hover-primary fs-6">{u.lokasi}</div>
                                            </td>
                                            <td>
                                                <img src={u.foto} alt="image" className="h-50 w-50 align-self-end" />
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