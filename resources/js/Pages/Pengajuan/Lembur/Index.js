import React from 'react'
import Authenticated from '@/Layouts/Authenticated'
import Paginate from '@/Components/Table/Paginate'
import Search from '@/Components/Table/Search'
import Dropdown from '@/Components/Crud/Dropdown'
import Reject from '@/Components/Crud/Reject'
import Approved from '@/Components/Crud/Approved'
import Logs from '@/Components/Crud/Logs'
import File from '@/Components/Table/File'

export default function Index({ lembur }) {

    const { data, meta } = lembur

    return (
        <div>
            <div className="toolbar mb-5 mb-lg-7 d-flex justify-content-between">
                <div className="page-title d-flex flex-column me-3">
                    <h1 className="d-flex text-dark fw-bolder my-1 fs-3">Pengajuan</h1>
                    <ul className="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                        <li className="breadcrumb-item text-gray-600">
                            <a href="/" className="text-gray-600 text-hover-primary">Home</a>
                        </li>
                        <li className="breadcrumb-item text-gray-600">Lembur</li>
                    </ul>
                </div>
            </div>
            <div className="content">
                <div className="card mb-5 mb-xl-8">
                    <div className="card-header border-0 pt-5">
                        <h3 className="card-title align-items-start flex-column">
                            <span className="card-label fw-bolder fs-3 mb-1">Data Pengajuan Lembur</span>
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
                                        <th>Jam Mulai</th>
                                        <th>Jam Selesai</th>
                                        <th>Keterangan</th>
                                        <th>Status</th>
                                        <th>Gambar</th>
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
                                                <div className="text-dark fw-bolder text-hover-primary fs-6">{u.nama}</div>
                                            </td>
                                            <td>
                                                <p>{u.tanggal}</p>
                                            </td>
                                            <td>
                                                <p>{u.jam_mulai}</p>
                                            </td>
                                            <td>
                                                <p>{u.jam_selesai}</p>
                                            </td>
                                            <td>
                                                <p>{u.keterangan}</p>
                                            </td>
                                            <td>
                                                <span dangerouslySetInnerHTML={{ __html: u.status }} />
                                            </td>
                                            <td>
                                                <File file={u.file} />
                                            </td>
                                            <td>
                                                <Dropdown>
                                                    <Logs model_type="App\Models\Pegawai\DataPengajuanLembur" model_id={u.id} />
                                                    {
                                                        u.kode_status == 0 ?
                                                            <>
                                                                <Reject routes={route('pengajuan.lembur.reject', u.id)} />
                                                                <Approved routes={route('pengajuan.lembur.approved', u.id)} />
                                                            </>
                                                            : ""
                                                    }
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