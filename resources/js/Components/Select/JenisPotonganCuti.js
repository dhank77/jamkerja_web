import React from 'react'
import Select from 'react-select'

export default function JenisPotonganCuti({ onchangeHandle, valueHandle }) {

    const options = [
        { value : 'potongan', keterangan: 'potongan', label: 'Potongan' },
        { value : 'penambahan', keterangan: 'penambahan', label: 'Penambahan' },
    ]

  return (
    <Select options={options} onChange={onchangeHandle} value={options.filter(obj => (obj.keterangan == valueHandle))} />
  )
}
