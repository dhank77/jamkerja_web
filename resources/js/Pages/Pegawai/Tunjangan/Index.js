import Delete from '@/Components/Crud/Delete';
import Download from '@/Components/Crud/Download';
import Dropdown from '@/Components/Crud/Dropdown';
import Edit from '@/Components/Crud/Edit';
import Logs from '@/Components/Crud/Logs';
import Paginate from '@/Components/Table/Paginate';
import Search from '@/Components/Table/Search';
import Authenticated from '@/Layouts/Authenticated'
import { Link } from '@inertiajs/inertia-react'
import React from 'react'
import Detail from '../Pegawai/Detail'

export default function Index({ pegawai, Rtunjangan }) {

    const { data, meta } = Rtunjangan;

    return (
        <Detail pegawai={pegawai}>
            <div className="card card-flush mt-6 mt-xl-9">
                <div className="card-header mt-5">
                    <div className="card-title flex-column">
                        <h3 className="fw-bolder mb-1">Data tunjangan</h3>
                        <div className="fs-6 text-gray-400">Data riwayat tunjangan</div>
                    </div>
                    <div class="card-toolbar">
                        <Link preserveScroll href={route('pegawai.tunjangan.add', pegawai.nip)} class="btn btn-primary fw-bolder me-auto px-4 py-3">Tambah</Link>
                    </div>
                </div>
                <div className="card-body py-3">
                    <Search />
                    <div className="table-responsive">
                        <table className="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3 min-h-250px">
                            <thead>
                                <tr className="fw-bolder text-muted">
                                    <th className='w-10'>No</th>
                                    <th>Nama Tunjangan</th>
                                    <th>Nominal</th>
                                    <th>Nomor SK</th>
                                    <th>Tanggal SK</th>
                                    <th>Status</th>
                                    <th>Private ?</th>
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
                                            <p> {u.tunjangan} </p>
                                        </td>
                                        <td>
                                            <p> {u.nilai} </p>
                                        </td>
                                        <td>
                                            <p> {u.nomor_sk} </p>
                                        </td>
                                        <td>
                                            <p>{u.tanggal_sk}</p>
                                        </td>
                                        <td>
                                            <div dangerouslySetInnerHTML={{ __html: u.status }} />
                                        </td>
                                        <td>
                                            {
                                                u.is_private == 0 ?
                                                <span className='badge badge-danger'>Tidak</span> :
                                                <span className='badge badge-success'>Ya</span>
                                            }
                                        </td>
                                        <td>
                                            <Download file={u.file} />
                                        </td>
                                        <td>
                                            <Dropdown>
                                                <Logs model_type="App\Models\Pegawai\RiwayatTunjangan" model_id={u.id} />
                                                <div className="dropdown-item menu-item px-3">
                                                    <Link href={route('pegawai.tunjangan.akhir', { 'pegawai': u.nip, 'Rtunjangan': u.id })} className="menu-link px-3">{
                                                        u.is_aktif == 1 ? <><i className='fa fa-book mr-2 text-danger'></i> Nonaktifkan</> : <><i className='fa fa-book mr-2 text-success'></i> Aktifkan</>
                                                    }</Link>
                                                </div>
                                                <Edit routes={route('pegawai.tunjangan.edit', { 'pegawai': u.nip, 'Rtunjangan': u.id })} />
                                                <Delete routes={route('pegawai.tunjangan.delete', { 'pegawai': u.nip, 'Rtunjangan': u.id })} />
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