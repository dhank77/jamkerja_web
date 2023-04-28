import React, { useEffect, useState } from 'react'
import Select from 'react-select'

export default function TunjanganMulti({ onchangeHandle, valueHandle }) {

  const [data, setData] = useState([])


  useEffect(() => {
    loadData();
  }, [])

  const loadData = async () => {
    try {
      let { data } = await axios.get(route('master.payroll.tunjangan.json'));
      setData(data);
    } catch (error) {
      console.log(error);
    }
  }

    return <Select options={data} onChange={onchangeHandle} value={valueHandle} isMulti />;
}
