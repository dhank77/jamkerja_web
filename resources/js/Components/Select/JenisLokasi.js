import React, { useEffect, useState } from 'react'
import Select from 'react-select'

export default function JenisLokasi({ onchangeHandle, valueHandle }) {

  const options = [
    { value : '1', keterangan: '1', label: 'Pilih Pegawai' },
    { value : '2', keterangan: '2', label: 'Berdasarkan Jabatan' },
    { value : '3', keterangan: '3', label: 'Berdasarkan Divisi' },
]
   

  return (
    <Select className='z-10' options={options} onChange={onchangeHandle} value={options.filter(obj => (obj.keterangan == valueHandle))} />
  )
}
