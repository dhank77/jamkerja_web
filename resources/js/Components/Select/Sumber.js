import React, { useEffect, useState } from 'react'
import Select from 'react-select'

export default function Sumber({ onchangeHandle, valueHandle, except = '' }) {

  const [data, setData] = useState([])

  useEffect(() => {
    loadData();
  }, [])

  const loadData = async () => {
    try {
      let { data } = await axios.get(route('master.payroll.penambahan.sumber', {tambah : except}));
      setData(data);
    } catch (error) {
      console.log(error);
    }
  }


  return (
    <Select isMulti options={data} onChange={onchangeHandle} />
  )
}
