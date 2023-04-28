import React from 'react'
import Select from 'react-select'

export default function IsPeriode({ onchangeHandle, valueHandle }) {

    const options = [
        { value : '0', is_periode: '0', label: 'Selamanya' },
        { value : '1', is_periode: '1', label: 'Periode Tertentu' },
    ]

  return (
    <Select options={options} onChange={onchangeHandle} value={options.filter(obj => (obj.is_periode == valueHandle))} />
  )
}
