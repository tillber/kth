# tenta.ex
defmodule Tenta do
  # sum
  def sum(nil) do 0 end
  def sum({:node, int, left, right}) do
    int + sum(left) + sum(right)
  end

  def testSum() do
    sum({:node, 5, {:node, 3, {:node, 2, nil, nil}, {:node, 2, nil, nil}}, {:node, 4, {:node, 1, nil, nil}, {:node, 6, nil, nil}}})
  end

  # mirror
  def mirror(nil) do nil end
  def mirror({:node, int, left, right}) do
    {:node, int, mirror(right), mirror(left)}
  end

  def testMirror() do
    mirror({:node, 5, {:node, 3, {:node, 2, nil, nil}, {:node, 2, nil, nil}}, {:node, 4, {:node, 1, nil, nil}, {:node, 6, nil, nil}}});
  end

  # double
  def double([]) do [] end
  def double([h|t]) do
    case rem(h, 2) do
      0 -> [2*h|double(t)]
      1 -> [h|double(t)]
    end
  end

  def testDouble() do double([1,2,3,4,5,6,7,8,9,10]) end

  # heap
  def add(nil, x) do
    {:node, x, nil, nil}
  end
  def add({:node, i, left, right}, x) do
    cond do
      x > i ->
        {:node, x, add(right, i), left}
      true ->
        {:node, i, add(right, x), left}
    end
  end

  def testHeap() do add({:node, 5, {:node, 3, {:node, 2, nil, nil}, {:node, 2, nil, nil}}, {:node, 4, {:node, 1, nil, nil}, {:node, 6, nil, nil}}}, 0) end

  # fizzbuzz
  def fizzbuzz(n) do fizzbuzz(1, n+1, 1, 1) end
  def fizzbuzz(n, n, _, _) do [] end
  def fizzbuzz(i, n, 5, 3) do [:fizzbuzz|fizzbuzz(i+1, n, 1, 1)] end
  def fizzbuzz(i, n, a, 3) do [:fizz|fizzbuzz(i+1, n, a+1, 1)] end
  def fizzbuzz(i, n, 5, b) do [:buzz|fizzbuzz(i+1, n, 1, b+1)] end
  def fizzbuzz(i, n, a, b) do [i|fizzbuzz(i+1, n, a+1, b+1)] end

  def testFizz() do
    fizzbuzz(20)
  end

  # reduce
  def reduce(nil, init, _) do init end
  def reduce({:node, value, left, right}, init, op) do
    op.(op.(reduce(left, init, op), value), reduce(right, init, op))
  end
  def testReduce(op) do
    reduce({:node, 5, {:node, 3, {:node, 2, nil, nil}, {:node, 2, nil, nil}},
    {:node, 4, {:node, 1, nil, nil}, {:node, 6, nil, nil}}}, 1, op)
  end

  # to_list
  #def to_list(nil, list) do list end
  def to_list(tree, op) do
    List.flatten(reduce(tree, [], op))
  end
  def testToList() do
    op = fn a,b -> [a,b] end
    to_list({:node, 5, {:node, 3, {:node, 2, nil, nil}, {:node, 2, nil, nil}}, {:node, 4, {:node, 1, nil, nil}, {:node, 6, nil, nil}}}, op)
  end

  # sum parallel
  def sump(nil) do 0 end
  def sump({:node, value, left, right}) do
    parent = self()

    spawn(fn() ->
      send(parent, {:result, sump(left) + value + sump(right)})
    end)

    receive do
      {:result, sum} -> sum
    end
  end

  # fairly
  def fairly({:node, _, left, right}) do
    {depth, diff} = {max(fairly(left, 0), fairly(right, 0)), abs(fairly(left, 0) - fairly(right, 0))}
    if diff > 1 do
      :no
    else
      {:ok, depth}
    end
  end
  def fairly(nil, i) do i end
  def fairly({:node, _, left, right}, i) do
    max(fairly(left, i+1), fairly(right, i+1))
  end

  # foldp
  def foldp([x], _op) do x end
  def foldp(list, op) do
    half = round(length(list) / 2)
    {right, left} = Enum.split(list, half)

    parent = self()
    spawn(fn() -> send(parent, {:result, op.(foldp(left, op), foldp(right, op))}) end)

    receive do
      {:result, res} -> res
    end
  end

  # reverse
  def reverse(list) do
    reverse(list, [])
  end
  def reverse([], list) do list end
  def reverse([h|t], res) do
    reverse(t, [h|res])
  end

  # append
  def append(list, []) do list end
  def append(list1, list2) do
    reverse(reverse(list1), list2)
  end
end
