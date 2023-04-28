import Slipgaji from '@/Components/App/Slipgaji';
import Approved from '@/Components/Crud/Approved';
import Cancel from '@/Components/Crud/Cancel';
import Delete from '@/Components/Crud/Delete';
import Dropdown from '@/Components/Crud/Dropdown';
import Reject from '@/Components/Crud/Reject';
import Paginate from '@/Components/Table/Paginate';
import Search from '@/Components/Table/Search';
import Authenticated from '@/Layouts/Authenticated'
import { Link } from '@inertiajs/inertia-react'
import React from 'react'

export default function Detail({ generate, payroll }) {

    const { data, meta } = payroll;

    return (
        <div className="card card-flush mt-6 mt-xl-9">
            <div className="card-header mt-5">
                <div className="card-title flex-column">
                    <h3 className="fw-bolder mb-1">Detail Generate Payroll</h3>
                </div>
                <div class="card-toolbar">
                    <Link href={route('payroll.generate.index')} class="btn btn-dark fw-bolder me-auto px-4 py-3">Kembali</Link>
                </div>
            </div>
            <div className="card-body py-3">
                <div className="alert alert-success">
                    <h6 className="fw-bolder mb-1">Kode Payroll : {generate.kode_payroll}</h6>
                    <h6 className="fw-bolder mb-1">Periode : {generate.bulan}</h6>
                    <h6 className="fw-bolder mb-1">Divisi : {generate.skpd}</h6>
                    <h6 className='fw-bolder'>
                        Status : <span dangerouslySetInnerHTML={{ __html: generate.status }} />
                    </h6>
                </div>
                <Search />
                <div className="table-responsive">
                    <table className="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3 min-h-250px">
                        <thead>
                            <tr className="fw-bolder text-muted">
                                <th className='w-10'>No</th>
                                <th>No. Pegawai <br /> Nama</th>
                                <th>Jabatan <br /> Divisi </th>
                                <th>Gaji Pokok</th>
                                <th>Total Penambahan</th>
                                <th>Total Potongan</th>
                                <th>Total Akhir</th>
                                <th>Status</th>
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
                                            {u.nip}
                                        </p>
                                        <p>{u.nama}</p>
                                    </td>
                                    <td>
                                        <p>{u.jabatan}</p>
                                        <p>{u.divisi}</p>
                                    </td>
                                    <td>
                                        <p>{u.gaji_pokok}</p>
                                    </td>
                                    <td>
                                        <p>{u.total_penambahan}</p>
                                    </td>
                                    <td>
                                        <p>{u.total_potongan}</p>
                                    </td>
                                    <td>
                                        <p>{u.total}</p>
                                    </td>
                                    <td>
                                        <span dangerouslySetInnerHTML={{ __html: u.is_aktif }} />
                                    </td>
                                    <td>
                                        <Dropdown>
                                            {
                                                u.Dis_aktif == 1 ?
                                                    <Cancel routes={route('payroll.generate.rejected', { generate: generate.id, payroll: u.id })} /> :
                                                    <Approved routes={route('payroll.generate.approved', { generate: generate.id, payroll: u.id })} />
                                            }
                                            <Slipgaji nip={u.nip} kode_payroll={generate.kode_payroll} />
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
    )
}

Detail.layout = (page) => <Authenticated children={page} />