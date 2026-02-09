using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Gunventory.Data;
using Microsoft.AspNetCore.Authorization;

namespace Gunventory.Pages;

[Authorize]
public class DeleteMalfunctionModel : PageModel
{
    private readonly GunventoryContext _context;

    public DeleteMalfunctionModel(GunventoryContext context)
    {
        _context = context;
    }

    public async Task<IActionResult> OnGetAsync(int? id)
    {
        if (id == null)
        {
            return NotFound();
        }

        var malfunction = await _context.Malfunctions.FindAsync(id);

        if (malfunction != null)
        {
            malfunction.Status = "I";
            await _context.SaveChangesAsync();
        }

        return Redirect(Request.Headers["Referer"].ToString() ?? "/Index");
    }
}
