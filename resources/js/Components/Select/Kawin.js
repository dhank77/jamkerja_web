import React from 'react'
import Select from 'react-select'

export default function Kawin({ onchangeHandle, valueHandle }) {

    const options = [
        { value : 'belum kawin', kode_kawin: 'belum kawin', label: 'Belum kawin' },
        { value : 'kawin', kode_kawin: 'kawin', label: 'Kawin' },
        { value : 'janda', kode_kawin: 'janda', label: 'Janda' },
        { value : 'duda', kode_kawin: 'duda', label: 'Duda' },
    ]

  return (
    <Select options={options} onChange={onchangeHandle} value={options.filter(obj => (obj.kode_kawin == valueHandle))} />
  )
}
