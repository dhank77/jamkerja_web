import React from 'react'
import Select from 'react-select'

export default function KeteranganPayroll({ onchangeHandle, valueHandle }) {

    const options = [
        { value : '0', keterangan: 'semua', label: 'Semua Pegawai' },
        { value : '1', keterangan: '1', label: 'Pegawai Tertentu' },
        { value : '2', keterangan: '2', label: 'Tingkat Jabatan' },
        { value : '3', keterangan: '3', label: 'Level Jabatan' },
        { value : '4', keterangan: '4', label: 'Divisi Kerja' },
    ]

  return (
    <Select options={options} onChange={onchangeHandle} value={options.filter(obj => (obj.keterangan == valueHandle))} />
  )
}
