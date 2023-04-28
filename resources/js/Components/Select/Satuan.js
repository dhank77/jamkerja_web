import React from 'react'
import Select from 'react-select'

export default function Satuan({ onchangeHandle, valueHandle }) {

    const options = [
        { value : '1', satuan: '1', label: 'Rupiah' },
        { value : '2', satuan: '2', label: 'Persen' },
    ]

  return (
    <Select options={options} onChange={onchangeHandle} value={options.filter(obj => (obj.satuan == valueHandle))} />
  )
}
