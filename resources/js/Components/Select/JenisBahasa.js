import React from 'react'
import Select from 'react-select'

export default function JenisBahasa({ onchangeHandle, valueHandle }) {

    const options = [
        { value : 'asing', jenis: 'asing', label: 'Asing' },
        { value : 'daerah', jenis: 'daerah', label: 'Daerah' },
    ]

  return (
    <Select options={options} onChange={onchangeHandle} value={options.filter(obj => (obj.jenis == valueHandle))} />
  )
}
