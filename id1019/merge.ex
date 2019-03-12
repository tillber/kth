# merge.ex
defmodule Merge do
  def msort([]) do [] end
  def msort(list) do
    {l1, l2} = Enum.split(list, round(length(list) / 2))
    IO.puts(inspect([l1, l2]))
    merge(msort(l1), msort(l2))
  end

  def merge([], r) do r end
  def merge(l, []) do l end
  def merge([h|t] = l, [h2|t2] = r) do
    cond do
      h2 > h ->
        [h|merge(t, r)]
      true ->
        [h2|merge(t2, l)]
    end
  end
end
