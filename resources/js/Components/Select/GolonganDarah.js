import React from 'react'
import Select from 'react-select'

export default function GolonganDarah({ onchangeHandle, valueHandle }) {

    const options = [
        { value : 'A', golongan_darah: 'A', label: 'A' },
        { value : 'B', golongan_darah: 'B', label: 'B' },
        { value : 'AB', golongan_darah: 'AB', label: 'AB' },
        { value : 'O', golongan_darah: 'O', label: 'O' },
    ]

  return (
    <Select options={options} onChange={onchangeHandle} value={options.filter(obj => (obj.golongan_darah == valueHandle))} />
  )
}
