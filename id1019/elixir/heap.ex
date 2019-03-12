# heap.ex
defmodule Heap do
  def msort([]) do [] end
  def msort(list) do
    {l1, l2} = msplit(list)
    merge(msort(l1), msort(l2))
  end

  def msplit(list) do msplit(list, [], []) end
  def msplit([], l1, l2) do {l1,l2} end
  def msplit([h|t], l1, l2) do msplit(t, [h|l2], l1) end

  def merge([], s) do s end
  def merge(l, []) do l end
  def merge([h1|l1], [h2|_t2] = l2) when h1 < h2 do
    [h1|merge(l1,l2)]
  end
  def merge(l1, [h2|l2]) do [h2|merge(l1,l2)] end

  def heap(nil) do [] end
  def heap({:heap, value, left, right}) do
    [value | merge(heap(left), heap(right))]
  end

  def pop(nil) do false end
  def pop({:heap, value, nil, nil}) do {:ok, value, nil} end
  def pop({:heap, value, left, right}) do
    {:heap, valuel, _left, _right} = left
    {:heap, valuer, _left, _right} = right
    if valuer < valuel do
      {:ok, _, rest} = pop(right)
      {:ok, value, {:heap, valuer, left, rest}}
    else
      {:ok, _, rest} = pop(left)
      {:ok, value, {:heap, valuel, rest, right}}
    end
  end
end
