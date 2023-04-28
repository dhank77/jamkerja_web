import Delete from '@/Components/Crud/Delete';
import Download from '@/Components/Crud/Download';
import Dropdown from '@/Components/Crud/Dropdown';
import Edit from '@/Components/Crud/Edit';
import Paginate from '@/Components/Table/Paginate';
import Search from '@/Components/Table/Search';
import Authenticated from '@/Layouts/Authenticated'
import { Link } from '@inertiajs/inertia-react'
import React from 'react'
import Detail from '../Pegawai/Detail'

export default function Index({ pegawai, Rstatus }) {

    const { data, meta } = Rstatus;

    return (
        <Detail pegawai={pegawai}>
            <div className="card card-flush mt-6 mt-xl-9">
                <div className="card-header mt-5">
                    <div className="card-title flex-column">
                        <h3 className="fw-bolder mb-1">Data status</h3>
                        <div className="fs-6 text-gray-400">Data riwayat status</div>
                    </div>
                    <div class="card-toolbar">
                        <Link preserveScroll href={route('pegawai.status.add', pegawai.nip)} class="btn btn-primary fw-bolder me-auto px-4 py-3">Tambah</Link>
                    </div>
                </div>
                <div className="card-body py-3">
                    <Search />
                    <div className="table-responsive">
                        <table className="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3 min-h-250px">
                            <thead>
                                <tr className="fw-bolder text-muted">
                                    <th className='w-10'>No</th>
                                    <th>Status</th>
                                    <th>Nomor SK</th>
                                    <th>Tanggal SK</th>
                                    <th>TMT status</th>
                                    <th>Gol</th>
                                    <th>Pangkat</th>
                                    <th>Berkas</th>
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
                                            <p>
                                                <span dangerouslySetInnerHTML={{ __html: u.is_akhir == 1 ? '<i class="bi bi-bookmark-star-fill text-danger fs-4"></i>' : '' }} />
                                                {u.status}
                                            </p>
                                        </td>
                                        <td>
                                            <p>{u.no_sk}</p>
                                        </td>
                                        <td>
                                            <p>{u.tanggal_sk}</p>
                                        </td>
                                        <td>
                                            <p>{u.tanggal_tmt}</p>
                                        </td>
                                        <td>
                                            <p>{u.golongan}</p>
                                        </td>
                                        <td>
                                            <p>{u.pangkat}</p>
                                        </td>
                                        <td>
                                            <Download file={u.file} />
                                        </td>
                                        <td>
                                            <Dropdown>
                                                {
                                                    u.is_akhir != 1 &&
                                                    <div className="dropdown-item menu-item px-3">
                                                        <Link href={route('pegawai.status.akhir', { 'pegawai': u.nip, 'Rstatus': u.id })} className="menu-link px-3"><i className='fa fa-book mr-2 text-success'></i> Jadikan status Akhir </Link>
                                                    </div>
                                                }
                                                <Edit routes={route('pegawai.status.edit', { 'pegawai': u.nip, 'Rstatus': u.id })} />
                                                <Delete routes={route('pegawai.status.delete', { 'pegawai': u.nip, 'Rstatus': u.id })} />
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
        </Detail>
    )
}

Index.layout = (page) => <Authenticated children={page} />