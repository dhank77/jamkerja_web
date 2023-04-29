import React from 'react'
import Authenticated from '@/Layouts/Authenticated'
import { Link } from '@inertiajs/inertia-react'
import Paginate from '@/Components/Table/Paginate'
import Search from '@/Components/Table/Search'
import Delete from '@/Components/Crud/Delete'
import Edit from '@/Components/Crud/Edit'
import Dropdown from '@/Components/Crud/Dropdown'
import JksModal from '@/Components/Modal/JksModal'
import { Calendar, Whisper, Popover, Badge } from 'rsuite';

export default function Index({ jkdJadwal, test }) {

    const { data, meta } = jkdJadwal

    function getTodoList(date) {
        const day = date.getDate();
       
        switch (day) {
          case 10:  return test[day];
          case 15:
            return [
              { kode_jkd: '09:30 pm', nama: 'Products Introduction Meeting' },
              { kode_jkd: '12:30 pm', nama: 'Client entertaining' },
              { kode_jkd: '02:00 pm', nama: 'Product design discussion' },
              { kode_jkd: '05:00 pm', nama: 'Product test and acceptance' },
              { kode_jkd: '06:30 pm', nama: 'Reporting' },
              { kode_jkd: '10:00 pm', nama: 'Going home to walk the dog' }
            ];
          default:
            return [];
        }
      }

    function renderCell(date) {
        const list = getTodoList(date);
        const displayList = list.filter((item, index) => index < 2);

        if (list.length) {
            const moreCount = list.length - displayList.length;
            const moreItem = (
                <li>
                    <Whisper
                        placement="top"
                        trigger="click"
                        speaker={
                            <Popover>
                                {list.map((item, index) => (
                                    <p key={index}>
                                        <b>{item.kode_jkd}</b> - {item.nama}
                                    </p>
                                ))}
                            </Popover>
                        }
                    >
                        <a className='badge badge-primary'>Detail</a>
                    </Whisper>
                </li>
            );

            return (
                <ul className="calendar-todo-list-new">
                    {displayList.map((item, index) => (
                        <li key={index}>
                            <Badge /> <b>{item.kode_jkd}</b> - {item.nama}
                        </li>
                    ))}
                    {moreCount ? moreItem : null}
                </ul>
            );
        }

        return null;
    }

    return (
        <div>
            <div className="toolbar mb-5 mb-lg-7 d-flex justify-content-between">
                <div className="page-title d-flex flex-column me-3">
                    <h1 className="d-flex text-dark fw-bolder my-1 fs-3">Master</h1>
                    <ul className="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                        <li className="breadcrumb-item text-gray-600">
                            <a href="/" className="text-gray-600 text-hover-primary">Home</a>
                        </li>
                        <li className="breadcrumb-item text-gray-600">Jam Kerja Dinamis - Jadwal</li>
                        <li className="breadcrumb-item text-gray-500">Index</li>
                    </ul>
                </div>
                <div className="d-flex align-items-center py-2 py-md-1" >
                    <Link href={route('master.jamKerjaDinamis.jkdJadwal.add')} className="btn btn-primary"><b>Tambah</b></Link>
                </div>
            </div>
            <div className="content">
                <div className="card mb-5 mb-xl-8">
                    <div className="card-header border-0 pt-5">
                        <h3 className="card-title align-items-start flex-column">
                            <span className="card-label fw-bolder fs-3 mb-1">Jadwal Jam Kerja Dinamis</span>
                        </h3>
                    </div>
                    <div className="card-body py-3">
                        <Calendar bordered renderCell={renderCell} />
                    </div>
                </div>
            </div>
        </div>
    )
}

Index.layout = (page) => <Authenticated children={page} />