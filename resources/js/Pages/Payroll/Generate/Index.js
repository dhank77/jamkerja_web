import Delete from '@/Components/Crud/Delete';
import Dropdown from '@/Components/Crud/Dropdown';
import Paginate from '@/Components/Table/Paginate';
import Search from '@/Components/Table/Search';
import Detail from '@/Components/Crud/Detail';
import Authenticated from '@/Layouts/Authenticated'
import { Link } from '@inertiajs/inertia-react'
import React from 'react'
import Action from '@/Components/Crud/Action';

export default function Index({ payroll }) {

    const { data, meta } = payroll;

    return (
        <div className="card card-flush mt-6 mt-xl-9">
            <div className="card-header mt-5">
                <div className="card-title flex-column">
                    <h3 className="fw-bolder mb-1">Daftar Generate Payroll</h3>
                </div>
                <div class="card-toolbar">
                    <Link href={route('payroll.generate.add')} class="btn btn-primary fw-bolder me-auto px-4 py-3">Generate</Link>
                </div>
            </div>
            <div className="card-body py-3">
                <Search />
                <div className="table-responsive">
                    <table className="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3 min-h-250px">
                        <thead>
                            <tr className="fw-bolder text-muted">
                                <th className='w-10'>No</th>
                                <th>Kode Payroll</th>
                                <th>Divisi Kerja</th>
                                <th>Bulan / Tahun</th>
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
                                            {u.kode_payroll}
                                        </p>
                                    </td>
                                    <td>
                                        <p>{u.skpd}</p>
                                    </td>
                                    <td>
                                        <p>{u.bulan}</p>
                                    </td>
                                    <td>
                                        <span dangerouslySetInnerHTML={{ __html : u.status }} />
                                    </td>
                                    <td>
                                        <Dropdown>
                                            <Action routes={route('payroll.generate.regenerate', u.id)} text="Generate Ulang" className="fa fa-recycle text-warning mr-2" />
                                            <Detail routes={route('payroll.generate.detail', u.id)} />
                                            <Delete routes={route('payroll.generate.delete', u.id)} />
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

Index.layout = (page) => <Authenticated children={page} />